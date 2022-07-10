<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Illuminate\Support\Collection;
use Src\Calculator\Application\Services\CalculateItem;
use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Math\MoneyTransformer;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ProductSales;
use Src\Sales\Domain\DataTransfer\Reports\ProductSalesCollection;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;

class MostSelledProducts
{
    public function __construct(
        private readonly CalculateItem $calculateItem,
        private readonly ItemsRepository $itemsRepository)
    {
    }

    /**
     * @return ProductSales[]
     */
    public function report(ListSalesFilter $options): ProductSalesCollection
    {
        $items = $this->itemsRepository->groupSaleItemsByProduct($options);

        $data =  $items->transform(
            fn (Collection $itemsCollection) => $this->transformItem($itemsCollection)
        )->filter(
            fn (?ProductSales $item) => !empty($item)
        )->sortByDesc('totalProfit');

        return new ProductSalesCollection($data->toArray());
    }

    private function transformItem(Collection $itemsCollection): ?ProductSales
    {
        if (!$product = $itemsCollection->first()->product) {
            return null;
        }

        $averagePrice = $this->getAveragePrice($itemsCollection);
        $itemsProfit = $this->getItemsProfit($itemsCollection);

        return new ProductSales(
            product: $product,
            count: $itemsCollection->count(),
            averagePrice: $this->getAveragePrice($itemsCollection),
            averageProfit: $this->getItemsProfit($itemsCollection),
            averageMargin: $itemsProfit / $averagePrice,
            totalRevenue: $this->getTotalRevenue($itemsCollection),
            totalProfit: $this->getTotalProfit($itemsCollection)
        );
    }

    private function getAveragePrice(Collection $itemsCollection)
    {
        return $itemsCollection->average('unit_value')
            - $itemsCollection->average('discount');
    }

    private function getItemsProfit(Collection $itemsCollection): float
    {
        return $itemsCollection->map(
            fn (Item $item) => $this->calculateItem($item)
        )->average();
    }

    private function getTotalProfit(Collection $itemsCollection): float
    {
        return $itemsCollection->map(
            fn (Item $item) => $this->calculateItem($item)
        )->sum();
    }

    private function getTotalRevenue(Collection $itemsCollection): float
    {
        return $itemsCollection->sum(
            fn (Item $item) => $item->getTotalValue()
        );
    }

    private function calculateItem(Item $item): float
    {
        try {
            $profit = $this->calculateItem->calculate($item)->getProfit();
        } catch (MarketplaceNotFoundException $exception) {
            return 0.0;
        }

        return MoneyTransformer::toString($profit);
    }
}
