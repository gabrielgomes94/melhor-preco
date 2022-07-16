<?php

namespace Src\Products\Domain\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductWithPriceRepository
{
    public function listProducts(string $storeSlug, string $userId, int $page = 1): LengthAwarePaginator;

    public function listProductsByCategory(string $storeSlug, string $categoryId, int $page = 1): LengthAwarePaginator;

    public function listProductsBySku(string $storeSlug, string $sku, int $page = 1): LengthAwarePaginator;

    public function listCompositionProducts(string $storeSlug, int $page): LengthAwarePaginator;
}
