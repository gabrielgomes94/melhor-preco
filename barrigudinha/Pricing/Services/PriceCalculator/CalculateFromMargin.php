<?php


namespace Barrigudinha\Pricing\Services\PriceCalculator;


use Barrigudinha\Pricing\Data\CalculatedPrice;
use Barrigudinha\Pricing\Data\CalculationParameters;

class CalculateFromMargin
{
    public static function calculate(CalculationParameters $calculatedPrice): CalculatedPrice
    {
        $markup = self::markup($calculatedPrice);
        $price = $calculatedPrice->costPrice()->divide($markup);

        $commissionValue = $price->multiply($calculatedPrice->commission);
        $taxSimplesNacionalValue = $price->multiply($calculatedPrice->taxSimplesNacional);

        $costs = $calculatedPrice
            ->costPrice()
            ->add($commissionValue)
            ->add($taxSimplesNacionalValue)
            ->add($calculatedPrice->additionalCosts);

        $profit = $price->subtract($costs);

        return new CalculatedPrice($profit, $price, $costs);
    }

    private static function markup(CalculationParameters $calculatedPrice)
    {
        return 1 - $calculatedPrice->commission - $calculatedPrice->taxSimplesNacional - $calculatedPrice->desiredMargin;
    }
}
