<?php

namespace Src\Prices\Domain\DataTransfer;

use Money\Money;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;

class CalculatorForm
{
    public readonly float $desiredPrice;
    public readonly float $freight;
    public readonly ?Percentage $discount;
    public readonly ?Percentage $commission;

    public function __construct(
        float $desiredPrice,
        ?Percentage $commission = null,
        ?Percentage $discount = null,
        float $freight = 0.0
    )
    {
        $this->discount = $discount ?: Percentage::fromPercentage(0);
        $this->desiredPrice = $desiredPrice;
        $this->commission = $commission;
        $this->freight =  $freight;
    }

    public function getPrice(): Money
    {
        $value = MoneyTransformer::toMoney($this->desiredPrice);

        return $value->multiply(
            (string) (1 - $this->discount->getFraction())
        );
    }
}
