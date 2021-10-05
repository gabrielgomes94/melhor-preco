<?php

namespace Src\Prices\Domain\Contracts\Services\Calculator;

use Barrigudinha\Product\Entities\Product;

interface SimulatePrice
{
    public function calculate(
        Product $product,
        float $desiredPrice,
        float $commission = 0.0,
        float $discount = 0.0
    ): array;
}
