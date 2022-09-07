<?php

namespace Src\Prices\Domain\Services;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Products\Domain\Models\Product;

interface CalculatePriceFromProduct
{
    public function calculate(
        Marketplace $marketplace,
        Product $product,
        ?CalculatorForm $calculatorForm
    ): PriceCalculatedFromProduct;
}
