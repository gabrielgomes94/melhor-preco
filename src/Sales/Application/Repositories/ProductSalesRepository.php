<?php

namespace Src\Sales\Application\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class ProductSalesRepository
{
    public function count(): int
    {
        return 1;
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

        return $itemsSelled->toArray();
    }

    public function groupSaleItemsByProduct(SalesFilter $options): array
    {
        $beginDate = $options->getBeginDate();
        $endDate = $options->getEndDate();

        return Item::with(['product', 'saleOrder'])
            ->join(
                'sales_orders',
                'sales_orders.sale_order_id',
                '=',
                'sales_items.sale_order_id'
            )
            ->where('selled_at', '>=', $beginDate)
            ->where('selled_at', '<=', $endDate)
            ->get()
            ->groupBy('sku')
            ->all();
    }
}
