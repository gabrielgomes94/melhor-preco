<?php

namespace Src\Sales\Application\Services;

use Money\Money;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData as PriceProductData;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Math\MoneyTransformer;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Store\Store;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Domain\Models\ValueObjects\Items\Item;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Services\Contracts\CalculateTotalProfit as CalculateTotalProfitInterface;
use Src\Sales\Infrastructure\Eloquent\Repositories\StoreRepository;
use Src\Sales\Infrastructure\Logging\Logging;

class CalculateTotalProfit implements CalculateTotalProfitInterface
{
    private CalculatePrice $calculatePrice;
    private ProductRepository $productRepository;
    private StoreRepository $storeRepository;

    public function __construct(
        CalculatePrice $calculatePrice,
        ProductRepository $productRepository,
        StoreRepository $storeRepository
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->productRepository = $productRepository;
        $this->storeRepository = $storeRepository;
    }

    public function execute(SaleOrder $saleOrder): float
    {
        $profit = Money::BRL(0);
        $items = $saleOrder->getItems()->get();

        foreach ($items as $item) {
            $this->calculateProfit($profit, $saleOrder, $item);
        }

        return MoneyTransformer::toFloat($profit ?? Money::BRL(0));
    }

    private function calculateProfit(Money &$profit, SaleOrder $saleOrder, Item $item)
    {
        if (!$product = $this->productRepository->get($item->sku())) {
            return;
        }

        if (!$store = $this->storeRepository->get($saleOrder)) {
            return;
        }

        $profit = $this->getProfit($product, $store, $item, $profit);

        Logging::priceCalculated($profit);
    }

    private function getCommission(Product $product, Store $store): Percentage
    {
        $post = $product?->getPost($store->getSlug());

        if (!$post) {
            return Percentage::fromFraction(0.0);
        }

        $comissionRate = $post
            ->getPrice()
            ->getCommission()
            ->getCommissionRate();

        return Percentage::fromFraction($comissionRate ?? 0.0);
    }

    private function getProductData($product): PriceProductData
    {
        return new PriceProductData(
            costs: $product->getCosts(),
            dimensions: $product->getDimensions()
        );
    }

    private function getProfit(Product $product, ?Store $store, Item $item, Money $profit): Money
    {
        $price = $this->calculatePrice->calculate(
            $this->getProductData($product),
            $store,
            $this->getValue($item),
            $this->getCommission($product, $store)
        );

        $profit = $profit->add(
            $price->getProfit()->multiply($item->quantity())
        );

        return $profit;
    }

    private function getValue(Item $item): float
    {
        $unitValue = MoneyTransformer::toMoney($item->unitValue());
        $discount = MoneyTransformer::toMoney($item->discount());
        $value = $unitValue->subtract($discount);

        return MoneyTransformer::toFloat($value);
    }
}
