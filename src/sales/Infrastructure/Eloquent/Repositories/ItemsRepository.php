<?php

namespace Src\Sales\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Events\ItemSynchronized;
use Src\Sales\Domain\Events\ItemWasNotSynchronized;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository as ItemRepositoryRepository;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

class ItemsRepository implements ItemRepositoryRepository
{
    public function groupSaleItemsByProduct(ListSalesFilter $options): Collection
    {
        $beginDate = $options->getBeginDate();
        $endDate = $options->getEndDate();

//        $sortOption = $options

        $items = Item::with(['product', 'saleOrder'])
            ->joinSaleOrders($beginDate, $endDate)
            ->orderByName()
            ->get()
            ->groupBy('sku');
//            ->sortKeys();
//            ->sortBy(function ($query) {
//                $query->
//            });

//        dd($items);

//        dd($items);

        return $items;
    }

    public function insert(
        SaleOrder $internalSaleOrder,
        Items $items
    ): void {
        foreach ($items->get() as $item) {
            $itemModel = Item::fromValueObject($item);

            $internalSaleOrder->items()->save($itemModel)
                ? event(new ItemSynchronized($itemModel->id))
                : event(new ItemWasNotSynchronized($itemModel->id)
            );
        }
    }
}
