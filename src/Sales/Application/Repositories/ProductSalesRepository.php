<?php

namespace Src\Sales\Application\Repositories;

use Carbon\Carbon;
use Src\Products\Domain\Models\Product;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Src\Sales\Domain\Repositories\ProductSalesRepository as ProductSalesRepositoryInterface;

class ProductSalesRepository implements ProductSalesRepositoryInterface
{
    public function count(Product $product, ?Carbon $beginDate = null, ?Carbon $endDate = null): int
    {
        $beginDate = $beginDate ?? Carbon::create(1900);
        $endDate = $endDate ?? Carbon::create(9999);

        $itemsSelled = Item::with(['product', 'saleOrder'])
            ->join(
                'sales_orders',
                'sales_orders.sale_order_id',
                '=',
                'sales_items.sale_order_id'
            )
            ->where('selled_at', '>=', $beginDate)
            ->where('selled_at', '<=', $endDate)
            ->where('sku', $product->getSku())
            ->where('user_id', $product->getUser()->getId())
            ->get();

        return $itemsSelled->sum('quantity');
    }

    public function getItemsSelled(Product $product, ?Carbon $beginDate = null, ?Carbon $endDate = null): array
    {
        $beginDate = $beginDate ?? Carbon::create(1900);
        $endDate = $endDate ?? Carbon::create(9999);

        $itemsSelled = collect($product->getSaleItems());

        $itemsSelled = $itemsSelled->filter(
            fn (Item $saleItem) =>
                $saleItem->getSelledAt() >= $beginDate &&
                $saleItem->getSelledAt() <= $endDate
        );

        return $itemsSelled->all();
    }
}
