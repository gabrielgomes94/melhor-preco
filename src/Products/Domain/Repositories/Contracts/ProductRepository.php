<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Src\Products\Application\Data\FilterOptions;
use Src\Products\Domain\Models\Product\Product;

interface ProductRepository
{
    public function all(): Collection;

    public function allFiltered(FilterOptions $filter): LengthAwarePaginator;

    public function count(): int;

    public function countActives(): int;

    public function get(string $sku): ?Product;

    public function getProductByEan(string $ean): ?Product;

    public function getLastSynchronizationDateTime(): ?Carbon;
}
