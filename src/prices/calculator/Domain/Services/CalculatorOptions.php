<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Contracts\Models\ProductData;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Store\Store;

interface CalculatorOptions
{
    public const DISCOUNT_RATE = 'discountRate';
    public const IGNORE_FREIGHT = 'ignoreFreight';

    public function calculate(
        ProductData $productData,
        Store $store,
        float $value,
        ?Percentage $commission,
        array $options = []
    ): Price;
}
