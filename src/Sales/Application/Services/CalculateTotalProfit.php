<?php

namespace Src\Sales\Application\Services;

use Money\Money;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData as PriceProductData;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Math\MoneyTransformer;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Domain\Models\ValueObjects\Items\Item;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Services\Contracts\CalculateTotalProfit as CalculateTotalProfitInterface;
use Src\Sales\Infrastructure\Logging\Logging;

class CalculateTotalProfit implements CalculateTotalProfitInterface
{
    private CalculatePrice $calculatePrice;
    private ProductRepository $productRepository;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(
        CalculatePrice $calculatePrice,
        ProductRepository $productRepository,
        MarketplaceRepository $marketplaceRepository
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->productRepository = $productRepository;
        $this->marketplaceRepository = $marketplaceRepository;
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

        if (
            !$marketplace = $this->marketplaceRepository->getByErpId(
                $saleOrder->getIdentifiers()->storeId()
            )
        ) {
            return;
        }

        $profit = $this->getProfit($product, $marketplace, $item, $profit);

        Logging::priceCalculated($profit);
    }

    private function getCommission(Product $product, Marketplace $marketplace): Percentage
    {
        $post = $product?->getPost($marketplace->getSlug());

        if (!$post) {
            return Percentage::fromFraction(0.0);
        }

        $comissionRate = $post
            ->getPrice()
            ->getCommission()
            ->getCommissionRate();

        return Percentage::fromFraction($comissionRate ?? 0.0);
    }

    private function getProductData(Product $product): PriceProductData
    {
        return new PriceProductData(
            costs: $product->getCosts(),
            dimensions: $product->getDimensions(),
            category: $product->getCategory(),
        );
    }

    private function getProfit(Product $product, Marketplace $marketplace, Item $item, Money $profit): Money
    {
        $price = $this->calculatePrice->calculate(
            $this->getProductData($product),
            $marketplace,
            $this->getValue($item),
            $this->getCommission($product, $marketplace)
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
