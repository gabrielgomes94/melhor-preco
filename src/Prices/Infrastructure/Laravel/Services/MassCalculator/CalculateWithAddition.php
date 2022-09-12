<?php

namespace Src\Prices\Infrastructure\Laravel\Services\MassCalculator;

use Src\Math\Calculators\MoneyCalculator;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class CalculateWithAddition extends BaseCalculator
{
    public function get(Price $price, Percentage $addition): CalculatedPrice
    {
        $desiredPrice = MoneyCalculator::multiply(
            $price->getValue(),
            1 + $addition->getFraction()
        );

        return $this->calculate($price, $desiredPrice);
    }
}
