<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\CalculatedPrice;
use Barrigudinha\Product\Product;
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
            if ($data['desiredPrice'] instanceof Money) {
                $desiredPrice = $data['desiredPrice'];
            } else {
                $desiredPrice = Helpers::floatToMoney((float) $data['desiredPrice']);
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
