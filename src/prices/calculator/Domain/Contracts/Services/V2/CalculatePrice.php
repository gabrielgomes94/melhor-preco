<?php

namespace Src\Prices\calculator\Domain\Contracts\Services;

use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Store\Store;

interface CalculatePrice
{
    public function calculate(Product $product, Store $store, float $desiredPrice, array $options = []);
}
