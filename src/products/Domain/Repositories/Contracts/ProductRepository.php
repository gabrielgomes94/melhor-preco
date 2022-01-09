<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Product;

interface ProductRepository
{
    public function count(): int;

    public function countActives(): int;

    public function get(string $sku): ?Product;

    public function getLastSynchronizationDateTime(): ?Carbon;

    public function all(): Collection;
}
