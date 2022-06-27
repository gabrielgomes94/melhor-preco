<?php

namespace Src\Prices\Infrastructure\Laravel\Services\PriceLog;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class ListProducts
{
    private const PER_PAGE = 15;

    public function listPaginate(string $storeSlug, int $page): LengthAwarePaginator
    {
        return Product::leftJoin('prices', 'prices.product_id', '=', 'products.sku')
            ->whereNull('parent_sku')
            ->where('is_active', true)
            ->where('prices.store', $storeSlug)
            ->orderBy('prices.updated_at', 'desc')
            ->paginate(perPage: self::PER_PAGE, page: $page);
    }
}
