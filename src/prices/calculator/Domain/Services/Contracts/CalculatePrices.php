<?php

namespace Src\Prices\Calculator\Domain\Services\Contracts;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Prices\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Products\Domain\Models\Store\Store;

interface CalculatePrices extends CalculatorOptions
{
    public function calculate(
        ProductData $productData,
        Store $store,
        float $value,
        ?Percentage $commission,
        array $options = []
    ): Price;
}
