<?php

namespace Src\Prices\Domain\Services;

use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;

interface CalculatePriceFromProduct
{
    public function calculate(
        string $productSku,
        string $marketplaceSlug,
        string $userId,
        ?CalculatorForm $calculatorForm
    ): PriceCalculatedFromProduct;
}
