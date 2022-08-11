<?php

namespace Src\Products\Domain\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Domain\Models\User;

interface ProductRepository
{
    public function all(string $userId): Collection;

    public function allFiltered(FilterOptions $filter, string $userId): LengthAwarePaginator;

    public function count(string $userId): int;

    public function countActives(string $userId): int;

    public function get(string $sku, string $userId): ?Product;

    public function getProductsAndVariations(string $sku, string $userId): array;

    public function getProductByEan(string $ean, string $userId): ?Product;

    public function getLastSynchronizationDateTime(string $userId): ?Carbon;

    public function save(Product $product, string $userId): bool;

    public function updateCosts(Product $product, Costs $costs, string $userId): bool;
}
