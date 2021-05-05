<?php

namespace Tests\Unit\Barrigudinha\Pricing\Services;

use Barrigudinha\Pricing\Data\CalculationParameters;
use Barrigudinha\Pricing\Data\Product;
use Barrigudinha\Pricing\Services\PriceCalculator\CalculateFromMargin;
use Tests\TestCase;

class CalculateFromMarginTest extends TestCase
{
    public function testShouldCalculate(): void
    {
        // Set
        $product = new Product([
            'id' => '1231',
            'name' => 'Produto de Teste',
            'sku' => '1231',
            'purchase_price' =>  1000.0,
            'tax_icms' => 12.0,
            'additional_costs' => 0.0,
        ]);
        $data = [
            'commission' => 0.0,
            'desiredMargin' => 20,
            'desiredPrice' => 0.0,
            'additionalCosts' => 0.0,
        ];
        $calculationParameters = new CalculationParameters($product, $data);
        $expected = [
            'profit' => '287.50',
            'costs' => '1149.99',
            'suggestedPrice' => '1437.49',
            'margin' => 20.0,
        ];

        // Act
        $result = CalculateFromMargin::calculate($calculationParameters);

        // Assert
        $this->assertSame($expected, $result->toArray());
    }
}
