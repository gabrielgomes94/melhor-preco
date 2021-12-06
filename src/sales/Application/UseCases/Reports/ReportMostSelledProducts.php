<?php

namespace Src\Sales\Application\UseCases\Reports;

use Illuminate\Database\Eloquent\Collection;
use Src\Prices\Calculator\Domain\Services\CalculateItem;
use Src\Prices\Calculator\Domain\Transformer\MoneyTransformer;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\UseCases\Contracts\Reports\ReportMostSelledProducts as ReportMostSelledProductsAlias;
use Src\Sales\Infrastructure\Eloquent\ItemRepository;

class ReportMostSelledProducts implements ReportMostSelledProductsAlias
{
    private CalculateItem $calculateItem;

    public function __construct(CalculateItem $calculateItem)
    {
        $this->calculateItem = $calculateItem;
    }

    public function report()
    {
        $items = ItemRepository::groupSaleItemsByProduct();

        $items = $items->transform(function (Collection $collection) {
                $product = $collection->first()->product;

                if (!$product) {
                    return [];
                }

                $averagePrice = $collection->average('unit_value') - $collection->average('discount');

                $totalRevenue = 0;
                foreach ($collection as $item) {
                    $totalRevenue += $item->getTotalValue();
                    $itemsProfit[] = $this->calculateItem($item);
                }
                $itemsProfit = collect($itemsProfit ?? []);

                return [
                    'sku' => $product->getSku(),
                    'name' => $product->getDetails()->getName(),
                    'count' => $collection->count(),
                    'average_price' => $averagePrice,
                    'average_profit' => $itemsProfit->average(),
                    'average_margin' => $itemsProfit->average() / $averagePrice,
                    'total_revenue' => $totalRevenue,
                    'total_profit' => $itemsProfit->sum(),
                ];
            });

        return $items;
    }

    private function calculateItem(Item $item): float
    {
        $profit = $this->calculateItem->calculate($item)->getProfit();

        return MoneyTransformer::toString($profit);
    }
}
