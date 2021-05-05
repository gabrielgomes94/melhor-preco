<?php

namespace Tests\Unit\Barrigudinha\Pricing\Services;

use Barrigudinha\Pricing\Data\CalculationParameters;
use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Services\PriceCalculator\CalculateFromMargin;
use Tests\Data\Pricing\ProductData;
use Tests\TestCase;

class CalculateFromMarginTest extends TestCase
{
    public function testShouldCalculate(): void
    {
        // Set
        $product = ProductData::build();
        $data = [
            'commission' => 0.0,
            'desiredMargin' => 20,
            'desiredPrice' => 0.0,
            'additionalCosts' => 0.0,
        ];
        $calculationParameters = new CalculationParameters($product, $data);
        $expected = [
            'suggestedPrice' => '1437.49',
            'costs' => '1149.99',
            'profit' => '287.50',
            'margin' => 20.0,
        ];

        // Act
        $result = CalculateFromMargin::calculate($calculationParameters);

        // Assert
        $this->assertSame($expected, $result->toArray());
    }
}
