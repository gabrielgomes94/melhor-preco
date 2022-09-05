<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Calculator;

use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class CalculateWithDiscount extends BaseCalculator
{
    public function get(Price $price, Percentage $discount): CalculatedPrice
    {
        $desiredPrice = MoneyTransformer::toMoney($price->getValue())
            ->multiply((string) (1 - $discount->getFraction()));

        $commission = $this->getCommission($price, $desiredPrice);
        $freight = $this->getFreight($price, $desiredPrice);

        return CalculatedPrice::fromProduct(
            $price->getProduct(),
            $commission,
            new CalculatorForm(
                desiredPrice: MoneyTransformer::toFloat($desiredPrice),
                freight: $freight
            )
        );
    }
}
