<?php

namespace Src\Sales\Application\Reports\Data\Product;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Math\Percentage;
use Src\Products\Domain\Models\Product;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Domain\Reports\Product\ProductSales as ProductSalesInterface;
use Src\Sales\Application\Models\Item;
use Src\Sales\Domain\Services\CalculateItem;

class ProductSales implements ProductSalesInterface
{
    public readonly Product $product;
    public readonly Collection $saleItemsCollection;
    private readonly CalculateItem $calculateItem;

    public function __construct(
        Product $product,
        SaleItemsCollection $saleItemsCollection,
        CalculateItem $calculateItem
    ) {
        $this->product = $product;
        $this->calculateItem = $calculateItem;

        $collection = collect($saleItemsCollection->get());
        $this->saleItemsCollection = $collection->filter(
            fn (Item $item) => $item->getProduct()->getUuid() === $product->getUuid()
        );
    }

    public function getAveragePrice(): float
    {
        $saleItems = $this->saleItemsCollection;

        $price = $saleItems->average('unit_value')
            - $saleItems->average('discount');

        return round($price, 2);
    }

    public function count(): int
    {
        return $this->saleItemsCollection->count();
    }

    public function getAverageProfit(): float
    {
        $calculatedItems = $this->saleItemsCollection->map(
            fn (Item $item) => $this->calculateItem($item)
        );

        if ($calculatedItems->isEmpty()) {
            return 0.0;
        }

        $averageProfit = $calculatedItems->average();

        return round($averageProfit, 2);
    }

    public function getAverageMargin(): Percentage
    {
        if ($this->getAveragePrice() == 0) {
            return Percentage::fromPercentage(0);
        }

        $margin = $this->getAverageProfit() / $this->getAveragePrice();

        return Percentage::fromFraction($margin);
    }

    public function getTotalRevenue(): float
    {
        $revenue = $this->saleItemsCollection->sum(
            fn (Item $item) => $item->getTotalValue()
        );

        return round($revenue, 2);
    }

    public function getTotalProfit(): float
    {
        $profit = $this->saleItemsCollection->map(
            fn (Item $item) => $this->calculateItem($item)
        )->sum();

        return round($profit, 2);
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getSaleItems(): SaleItemsCollection
    {
        return new SaleItemsCollection(
            $this->saleItemsCollection->toArray()
        );
    }

    public function getLastSales(int $limit = 5): SaleItemsCollection
    {
        $lastSales = $this->saleItemsCollection->sortByDesc(
            fn (Item $saleItem) => $saleItem->getSelledAt()
        )->take($limit);

        return new SaleItemsCollection($lastSales->toArray());
    }

    private function calculateItem(Item $item): float
    {
        try {
            $profit = $this->calculateItem->calculate($item)->getProfit();
        } catch (MarketplaceNotFoundException $exception) {
            return 0.0;
        }

        return $profit;
    }
}
