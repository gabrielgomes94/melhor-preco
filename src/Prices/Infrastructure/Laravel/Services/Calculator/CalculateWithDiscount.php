<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Calculator;

use Src\Math\MoneyCalculator;
use Src\Math\MoneyTransformer;
use Src\Math\Percentage;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class CalculateWithDiscount extends BaseCalculator
{
    public function get(Price $price, Percentage $discount): CalculatedPrice
    {
        $desiredPrice = MoneyCalculator::multiply(
            $price->getValue(),
            1 - $discount->getFraction()
        );
        $commission = $this->getCommission($price, $desiredPrice);
        $freight = $this->getFreight($price, $desiredPrice);

        return CalculatedPrice::fromProduct(
            $price->getProduct(),
            $commission,
            new CalculatorForm(
                desiredPrice: $desiredPrice,
                freight: $freight
            )
        );
    }
}
