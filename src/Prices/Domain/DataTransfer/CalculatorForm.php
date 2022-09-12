<?php

namespace Src\Prices\Domain\DataTransfer;

use Src\Math\Calculators\MoneyCalculator;
use Src\Math\Percentage;

class CalculatorForm
{
    public readonly float $desiredPrice;
    public readonly float $freight;
    public readonly ?Percentage $discount;
    public readonly ?Percentage $commission;

    public function __construct(
        float $desiredPrice,
        float $freight = 0.0,
        ?Percentage $commission = null,
        ?Percentage $discount = null,
    )
    {
        $this->discount = $discount ?: Percentage::fromPercentage(0);
        $this->desiredPrice = $desiredPrice;
        $this->commission = $commission;
        $this->freight =  $freight;
    }

    public function getPrice(): float
    {
        $discountPercentage = 1 - $this->discount->getFraction();

        return MoneyCalculator::multiply(
            $this->desiredPrice,
            $discountPercentage
        );
    }
}
