<?php

namespace Src\Sales\Application\Repositories;

use Carbon\Carbon;
use Src\Products\Domain\Models\Product;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class ProductSalesRepository
{
    public function count()
    {}

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
}
