<?php

namespace Src\Prices\Domain\Contracts\Services\Calculator;

use Barrigudinha\Product\Entities\Product;

interface CalculateProduct
{
    public function recalculate(Product $product): Product;
}
