<?php

namespace Src\Products\Domain\Repositories\Contracts;

use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Product;

interface ProductRepository
{
    public function get(string $sku): ?Product;

    public function all(): Collection;
}
