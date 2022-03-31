<?php

namespace Src\Sales\Infrastructure\Eloquent\Repositories;

use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Sales\Domain\Events\ItemSynchronized;
use Src\Sales\Domain\Events\ItemWasNotSynchronized;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\Repositories\Contracts\ItemsRepository as ItemRepositoryRepository;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

class ItemsRepository implements ItemRepositoryRepository
{
    public function countSalesByProduct(Product $product, ListSalesFilter $options): int
    {
        $beginDate = $options->getBeginDate();
        $endDate = $options->getEndDate();

        return Item::with(['product', 'saleOrder'])
            ->join(
                'sale_orders',
                'sale_orders.sale_order_id',
                '=',
                'sales_items.sale_order_id'
            )
            ->where('selled_at', '>=', $beginDate)
            ->where('selled_at', '<=', $endDate)
            ->where('sku', $product->getIdentifiers()->getSku())
            ->count();
    }

    public function groupSaleItemsByProduct(ListSalesFilter $options): Collection
    {
        $beginDate = $options->getBeginDate();
        $endDate = $options->getEndDate();

        return Item::with(['product', 'saleOrder'])
            ->join(
                'sale_orders',
                'sale_orders.sale_order_id',
                '=',
                'sales_items.sale_order_id'
            )
            ->where('selled_at', '>=', $beginDate)
            ->where('selled_at', '<=', $endDate)
            ->get()
            ->groupBy('sku');
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
