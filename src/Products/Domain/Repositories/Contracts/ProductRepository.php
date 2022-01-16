<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Product;

interface ProductRepository
{
    public function all(): Collection;

    public function count(): int;

    public function countActives(): int;

    public function get(string $sku): ?Product;

    public function getLastSynchronizationDateTime(): ?Carbon;

    public function listProducts(string $storeSlug, int $page = 1): LengthAwarePaginator;

    public function listProductsByCategory(string $storeSlug, string $categoryId, int $page = 1): LengthAwarePaginator;

    public function listProductsBySku(string $storeSlug, string $sku, int $page = 1): LengthAwarePaginator;

    public function listCompositionProducts(string $storeSlug, int $page): LengthAwarePaginator;
}
