<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Calculator;

use Src\Math\MoneyCalculator;
use Src\Prices\Domain\DataTransfer\CalculatorForm;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Prices\Domain\Models\Calculator\CostPrice;
use Src\Prices\Infrastructure\Laravel\Models\Price;

class CalculateFromMarkup extends BaseCalculator
{
    public function get(Price $price, float $markup): CalculatedPrice
    {
        $product = $price->getProduct();
        $costs = CostPrice::fromProduct($product);
        $desiredPrice = MoneyCalculator::multiply($costs->get(), $markup);

        $commission = $this->getCommission($price, $desiredPrice);
        $freight = $this->getFreight($price, $desiredPrice);

        return CalculatedPrice::fromProduct(
            $product,
            $commission,
            new CalculatorForm(
                desiredPrice: $desiredPrice,
                freight: $freight
            )
        );
    }
}
