<?php


namespace Barrigudinha\Pricing\Services\PriceCalculator;


use Barrigudinha\Utils\Helpers;

trait SimplesNacional
{
    public function taxSimplesNacional()
    {
        return Helpers::percentage(config('taxes.simples_nacional'));
    }
}
