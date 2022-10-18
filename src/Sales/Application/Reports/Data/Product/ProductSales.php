<?php

namespace Src\Sales\Application\Reports\Data\Product;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Products\Domain\Models\Product;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Infrastructure\Laravel\Services\CalculateItem;

class ProductSales implements \Src\Sales\Domain\Reports\Product\ProductSales
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
        $saleItems = collect($this->saleItemsCollection);

        return $saleItems->average('unit_value')
            - $saleItems->average('discount');
    }

    public function count(): int
    {
        $saleItems = collect($this->saleItemsCollection);

        return $saleItems->count();
    }

    public function getAverageProfit(): float
    {
        $saleItems = collect($this->saleItemsCollection);
        $calculatedItems = $saleItems->map(
            fn (Item $item) => $this->calculateItem($item)
        );

        if ($calculatedItems->isEmpty()) {
            return 0.0;
        }

        return $calculatedItems->average();
    }

    public function getAverageMargin(): float
    {
        if ($this->getAveragePrice() == 0) {
            return 0;
        }

        return $this->getAverageProfit() / $this->getAveragePrice();
    }

    public function getTotalRevenue(): float
    {
        $saleItems = collect($this->saleItemsCollection);

        return $saleItems->sum(
            fn (Item $item) => $item->getTotalValue()
        );
    }

    public function getTotalProfit(): float
    {
        $saleItems = collect($this->saleItemsCollection);

        return $saleItems->map(
            fn (Item $item) => $this->calculateItem($item)
        )->sum();
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
