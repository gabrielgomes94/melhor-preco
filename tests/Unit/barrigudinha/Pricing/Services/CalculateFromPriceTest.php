<?php

namespace Tests\Unit\Barrigudinha\Pricing\Services;

use Barrigudinha\Pricing\Data\CalculationParameters;
use Barrigudinha\Pricing\Services\PriceCalculator\FromMargin;
use Barrigudinha\Pricing\Services\PriceCalculator\CalculateFromPrice;
use Tests\Data\Pricing\ProductData;
use Tests\TestCase;

class CalculateFromPriceTest extends TestCase
{
    public function testShouldCalculate(): void
    {
        // Set
        $product = ProductData::build();
        $data = [
            'commission' => 0.0,
            'desiredMargin' => 0,
            'desiredPrice' => 1500.0,
            'additionalCosts' => 0.0,
        ];
        $calculationParameters = new CalculationParameters($product, $data);
        $expected = [
            'suggestedPrice' => '1500.00',
            'costs' => '1152.90',
            'profit' => '347.10',
            'margin' => 23.14,
        ];

        // Act
        $result = CalculateFromPrice::calculate($calculationParameters);

        // Assert
        $this->assertSame($expected, $result->toArray());
    }
}
