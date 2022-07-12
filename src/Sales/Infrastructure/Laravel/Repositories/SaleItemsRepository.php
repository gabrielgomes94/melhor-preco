<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Domain\Repositories\SaleItemsRepository as ItemRepositoryRepository;

class SaleItemsRepository implements ItemRepositoryRepository
{
    public function countSalesByProduct(Product $product, Carbon $beginDate, Carbon $endDate): int
    {
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

    public function groupSaleItemsByProduct(SalesFilter $options): Collection
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
}
