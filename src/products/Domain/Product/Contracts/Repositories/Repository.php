<?php

namespace Src\Products\Domain\Product\Contracts\Repositories;

use Src\Products\Domain\Product\Models\Product;

interface Repository
{
    public function get(string $sku): ?Product;
}
