<?php

namespace Src\Prices\Calculator\Domain\Contracts\Services\V1;

use Src\Products\Domain\Entities\Product;

interface CalculateProduct
{
    public function recalculate(Product $product): Product;
}
