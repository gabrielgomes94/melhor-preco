<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductWithPriceRepository
{
    public function listProducts(string $storeSlug, int $page = 1): LengthAwarePaginator;

    public function listProductsByCategory(string $storeSlug, string $categoryId, int $page = 1): LengthAwarePaginator;

    public function listProductsBySku(string $storeSlug, string $sku, int $page = 1): LengthAwarePaginator;

    public function listCompositionProducts(string $storeSlug, int $page): LengthAwarePaginator;
}
