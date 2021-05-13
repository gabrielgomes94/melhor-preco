<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

class Markup
{
    public static function calculate(float $commission, float $taxSimplesNacional, float $desiredMargin)
    {
        return 1 - $commission - $taxSimplesNacional - $desiredMargin;
    }
}
