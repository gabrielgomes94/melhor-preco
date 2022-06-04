<?php

namespace Src\Costs\Infrastructure\NFe\Services;

use Src\Costs\Infrastructure\NFe\Data\Product;
use Src\Math\MoneyTransformer;

class CalculateUnitCost
{
    public function calculate(Product $product): float
    {
        $price = MoneyTransformer::toMoney($product->price);
        $freightValue = MoneyTransformer::toMoney($product->getUnitFreightValue());
        $insuranceValue = MoneyTransformer::toMoney($product->getUnitInsuranceValue());
        $discount = MoneyTransformer::toMoney($product->discount);

        $taxes = $product->taxes;
        $ipiValue = MoneyTransformer::toMoney($taxes->ipi->value)->divide($product->quantity);

        $unitCost = $price->add($freightValue)
            ->add($insuranceValue)
            ->add($ipiValue)
            ->subtract($discount);

        return MoneyTransformer::toFloat($unitCost);
    }
}
