<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\CalculatedPrice;
use Barrigudinha\Pricing\Data\CalculationParameters;

class CalculateFromPrice
{
    public static function calculate(CalculationParameters $calculatedPrice): CalculatedPrice
    {
        $commissionValue = $calculatedPrice
            ->desiredSellingPrice
            ->multiply($calculatedPrice->commission);

        $taxSimplesNacionalValue = $calculatedPrice
            ->desiredSellingPrice
            ->multiply($calculatedPrice->taxSimplesNacional);

        $costs = $calculatedPrice
            ->costPrice()
            ->add($commissionValue)
            ->add($taxSimplesNacionalValue);

        $profit = $calculatedPrice->desiredSellingPrice->subtract($costs);

        return new CalculatedPrice(
            profit: $profit,
            price: $calculatedPrice->desiredSellingPrice,
            costs: $costs
        );
    }
}
