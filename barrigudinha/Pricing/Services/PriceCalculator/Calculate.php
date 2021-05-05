<?php

namespace Barrigudinha\Pricing\Services\PriceCalculator;

use Barrigudinha\Pricing\Data\CalculationParameters;
use Barrigudinha\Pricing\Data\Product;
use Illuminate\Http\Request;

class Calculate
{
    public function calculate(Product $product, array $data): array
    {
        $calculatePrice = new CalculationParameters($product, $data);

        if ($calculatePrice->desiredMargin) {
            return CalculateFromMargin::calculate($calculatePrice)->toArray();
        }

        if ($calculatePrice->desiredSellingPrice) {
            return CalculateFromPrice::calculate($calculatePrice)->toArray();
        }

        return [
            'profit' => '',
            'costs' => '',
            'suggestedPrice' => '',
            'margin' => '',
        ];
    }
}
