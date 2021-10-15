<?php

namespace Src\Prices\Calculator\Domain\Contracts\Services;

use Src\Products\Domain\Entities\Product;

interface CalculateProduct
{
    public function recalculate(Product $product): Product;

    public function calculate(
        Product $product,
        float $desiredPrice,
        float $commission = 0.0,
        float $discount = 0.0
    ): array;
}
