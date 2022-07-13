<?php

namespace Src\Calculator\Domain\Services\Contracts;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\Models\Calculator\Contracts\Price;
use Src\Calculator\Domain\Models\Product\Contracts\ProductData;
use Src\Math\Percentage;

interface CalculatePrices extends CalculatorOptions
{
    public function calculate(
        ProductData $productData,
        Marketplace $marketplace,
        float $value,
        ?Percentage $commission,
        array $options = []
    ): Price;
}
