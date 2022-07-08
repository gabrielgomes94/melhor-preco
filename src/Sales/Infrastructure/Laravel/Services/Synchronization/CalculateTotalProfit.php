<?php

namespace Src\Sales\Infrastructure\Laravel\Services\Synchronization;

use Money\Money;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData as PriceProductData;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Math\MoneyTransformer;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\PostRepository;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\Models\ValueObjects\Items\Item;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Services\Contracts\CalculateTotalProfit as CalculateTotalProfitInterface;
use Src\Sales\Infrastructure\Logging\Logging;

// @todo: simplify this class
class CalculateTotalProfit implements CalculateTotalProfitInterface
{
    private CalculatePrice $calculatePrice;
    private MarketplaceRepository $marketplaceRepository;
    private PostRepository $postRepository;
    private ProductRepository $productRepository;

    public function __construct(
        CalculatePrice $calculatePrice,
        MarketplaceRepository $marketplaceRepository,
        PostRepository $postRepository,
        ProductRepository $productRepository,
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->postRepository = $postRepository;
        $this->productRepository = $productRepository;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function execute(SaleOrder $saleOrder, string $userId): float
    {
        $profit = Money::BRL(0);
        $items = $saleOrder->getItems()->get();

        foreach ($items as $item) {
            $this->calculateProfit($profit, $saleOrder, $item, $userId);
        }

        return MoneyTransformer::toFloat($profit ?? Money::BRL(0));
    }

    private function calculateProfit(Money &$profit, SaleOrder $saleOrder, Item $item, string $userId)
    {
        if (!$product = $this->productRepository->get($item->sku(), $userId)) {
            return;
        }

        if (
            !$marketplace = $this->marketplaceRepository->getByErpId(
                $saleOrder->getIdentifiers()->storeId() ?? '',
                $userId
            )
        ) {
            return;
        }

        $profit = $this->getProfit($product, $marketplace, $item, $profit);

        Logging::priceCalculated($profit);
    }

    // @todo: usar o repositório de commissões ao invés dessa lógica
    private function getCommission(Product $product, Marketplace $marketplace): Percentage
    {
        $post = $this->postRepository->get($product, $marketplace);

        if (!$post) {
            return Percentage::fromFraction(0.0);
        }

        $commissionRate = $post
            ->getPrice()
            ->getCommission()
            ->getFraction();

        return Percentage::fromFraction($commissionRate ?? 0.0);
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
