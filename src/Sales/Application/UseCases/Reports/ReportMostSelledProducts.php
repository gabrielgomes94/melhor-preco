<?php

namespace Src\Sales\Application\UseCases\Reports;

use Closure;
use Illuminate\Support\Collection;
use Src\Math\Money;
use Src\Math\Percentage;
use Src\Calculator\Domain\Services\CalculateItem;
use Src\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;
use Src\Sales\Domain\UseCases\Contracts\Reports\ReportMostSelledProducts as ReportMostSelledProductsAlias;

class ReportMostSelledProducts implements ReportMostSelledProductsAlias
{
    private CalculateItem $calculateItem;
    private ItemsRepository $itemsRepository;

    public function __construct(CalculateItem $calculateItem, ItemsRepository $itemsRepository)
    {
        $this->calculateItem = $calculateItem;
        $this->itemsRepository = $itemsRepository;
    }

    public function report(ListSalesFilter $options)
    {
        $items = $this->itemsRepository->groupSaleItemsByProduct($options);
        $items = $items->transform(
                /**
                 * @var $collection Collection<Item>
                 */
                function (Collection $collection) {
                    return $this->transformItem($collection);
                }
            )->filter($this->hasItem())
            ->sortByDesc('count');

        return $items;
    }

    private function calculateItem(Item $item): float
    {
        $profit = $this->calculateItem->calculate($item)->getProfit();

        return MoneyTransformer::toString($profit);
    }

    private function transformItem(Collection $collection): array
    {
        if (!$product = $collection->first()->product) {
            return [];
        }

        $averagePrice = $collection->average('unit_value') - $collection->average('discount');
        $totalRevenue = $this->getTotalRevenue($collection);
        $itemsProfit = $this->getItemsProfit($collection);
        $averageMargin = $itemsProfit->average() / $averagePrice;

        return [
            'sku' => $product->getSku(),
            'name' => $product->getDetails()->getName(),
            'count' => $collection->count(),
            'average_price' => $this->formatPrice($averagePrice),
            'average_profit' => $this->formatPrice($itemsProfit->average()),
            'average_margin' => $this->formatPercentage($averageMargin),
            'total_revenue' => $this->formatPrice($totalRevenue),
            'total_profit' => $this->formatPrice($itemsProfit->sum()),
        ];
    }

    private function formatPercentage(float $fraction): string
    {
        return (string) Percentage::fromFraction($fraction);
    }

    private function formatPrice(float $price): string
    {
        return (string) Money::fromFloat($price);
    }
    private function getItemsProfit(Collection $collection): Collection
    {
        foreach ($collection as $item) {
            $itemsProfit[] = $this->calculateItem($item);
        }

        return collect($itemsProfit ?? []);
    }

    private function getTotalRevenue(Collection $collection): float
    {
        $totalRevenue = 0;

        foreach ($collection as $item) {
            $totalRevenue += $item->getTotalValue();
        }

        return $totalRevenue;
    }

    private function hasItem(): Closure
    {
        return function ($item) {
            return !empty($item);
        };
    }
}
