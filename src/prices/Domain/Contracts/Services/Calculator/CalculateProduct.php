<?php

namespace Src\Prices\Domain\Contracts\Services\Calculator;

use Src\Products\Domain\Entities\Product;

interface CalculateProduct
{
    public function recalculate(Product $product): Product;
}
