<?php

namespace Src\Prices\Calculator\Domain\Services\Contracts;

use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Store\Store;

interface CalculateProduct extends CalculatorOptions
{
    public function calculate(Product $product, Store $store);
}
