<?php

namespace Src\Prices\Calculator\Domain\Services\Contracts;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Store\Store;

interface CalculatePrices extends CalculatorOptions
{
    public function calculate(
        \Src\Prices\Calculator\Domain\Models\Product\Contracts\ProductData $productData,
        Store $store,
        float $value,
        ?Percentage $commission,
        array $options = []
    ): Price;
}
