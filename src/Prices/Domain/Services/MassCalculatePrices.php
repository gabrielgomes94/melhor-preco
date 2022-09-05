<?php

namespace Src\Prices\Domain\Services;

use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
use Src\Prices\Domain\DataTransfer\MassCalculatorForm;

interface MassCalculatePrices
{
    public function calculate(
        string $marketplaceSlug,
        string $userId,
        MassCalculatorForm $form
    ): ListPricesCalculated;
}
