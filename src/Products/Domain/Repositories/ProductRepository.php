<?php

namespace Src\Products\Domain\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Domain\Entities\User;

interface ProductRepository
{
    public function all(): Collection;

    public function allFiltered(FilterOptions $filter): LengthAwarePaginator;

    public function count(): int;

    public function countActives(): int;

    public function get(string $sku): ?Product;

    public function getProductsAndVariations(string $sku): array;

    public function getProductByEan(string $ean): ?Product;

    public function getLastSynchronizationDateTime(): ?Carbon;

    public function save(Product $product, User $user): bool;

    public function updateCosts(Product $product, Costs $costs): bool;
}
