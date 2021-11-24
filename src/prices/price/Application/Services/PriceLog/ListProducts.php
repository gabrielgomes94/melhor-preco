<?php

namespace Src\Prices\Price\Application\Services\PriceLog;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Products\Domain\Product\Models\Product;

class ListProducts
{
    private const PER_PAGE = 15;

    public function listPaginate(string $storeSlug, int $page): LengthAwarePaginator
    {
        return Product::listPricesLog($storeSlug, $page, self::PER_PAGE);
    }
}