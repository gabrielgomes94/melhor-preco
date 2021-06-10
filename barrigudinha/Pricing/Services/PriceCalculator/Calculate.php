<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\CalculatedPrice;
use Barrigudinha\Pricing\Data\CostPrice;
use Barrigudinha\Product\Product;
use Barrigudinha\Pricing\Data\Tax;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculators\FromMargin;
use Barrigudinha\Pricing\Services\PriceCalculator\Calculators\FromPrice;
use Barrigudinha\Utils\Helpers;
use Money\Money;

class Calculate
{
    public function calculate(Product $product, array $data): array
    {
        $commission = Helpers::percentage($data['commission']);
        $additionalCosts = Helpers::floatToMoney($data['additionalCosts'] ?? 0.0);

        if (isset($data['desiredPrice'])) {
            if (is_float($data['desiredPrice'])) {
                $desiredPrice = Helpers::floatToMoney($data['desiredPrice']);
            } else {
                $desiredPrice = $data['desiredPrice'];
            }


            $calculator = new FromPrice(
                product: $product,
                commission: $commission,
                additionalCosts: $additionalCosts,
                extra: ['desiredPrice' => $desiredPrice, 'store' => $data['store']],
            );
            return (new CalculatedPrice(
                price: $calculator->price(),
                costs: $calculator->costs(),
                commission: $calculator->commission(),
                freight: $calculator->freight(),
                taxSimplesNacional: $calculator->simplesNacional(),
                differenceICMS: $calculator->differenceICMS(),
                purchasePrice: $calculator->purchasePrice()
            ))->toArray();
        }
        return [];
    }
}
