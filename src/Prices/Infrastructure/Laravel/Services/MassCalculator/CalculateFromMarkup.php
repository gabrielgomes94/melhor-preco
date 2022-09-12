<?php

namespace Src\Prices\Infrastructure\Laravel\Services\MassCalculator;

use Src\Math\Calculators\MoneyCalculator;
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

        return $this->calculate($price, $desiredPrice);
    }
}
