<?php

namespace Src\Prices\Domain\Services\Price;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\Contracts\CalculatedPrice as CalculatedPriceInterface;
use Src\Products\Domain\Models\Product\Product;

interface CalculatePrice
{
    public function calculate(
        Product $product,
        Marketplace $marketplace,
        float $value,
        CalculatorForm $options
    ): CalculatedPriceInterface;
}
