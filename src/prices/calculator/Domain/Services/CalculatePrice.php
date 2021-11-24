<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Contracts\Models\ProductData;
use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Store\Store;

class CalculatePrice implements CalculatorOptions
{
    public function calculate(
        ProductData $productData,
        Store $store,
        float $value,
        ?Percentage $commission,
        array $options = []
    ): Price {
        $commission = $commission
            ? $commission->get()
            : $store->getDefaultCommission();

        return new Price(
            product: $productData,
            store: $store,
            value: $value,
            commission: $commission,
            options: $options
        );
    }
}
