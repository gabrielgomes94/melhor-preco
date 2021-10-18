<?php

namespace Src\Products\Infrastructure\Repositories\V2;

use Src\Products\Domain\Product\Contracts\Repositories\Repository as RepositoryInterface;
use Src\Products\Domain\Product\Models\Product;

class Repository implements RepositoryInterface
{
    public function get(string $sku): ?Product
    {
        return Product::find($sku);
    }
}
