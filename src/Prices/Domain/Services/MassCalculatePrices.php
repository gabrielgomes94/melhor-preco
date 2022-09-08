<?php

namespace Src\Prices\Domain\Services;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
use Src\Prices\Domain\DataTransfer\MassCalculatorForm;

interface MassCalculatePrices
{
    public function calculate(Marketplace $marketplace, MassCalculatorForm $form): ListPricesCalculated;
}
