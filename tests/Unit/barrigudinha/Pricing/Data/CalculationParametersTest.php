<?php

namespace Tests\Unit\Barrigudinha\Pricing\Data;

use Barrigudinha\Pricing\Data\CalculationParameters;
use Money\Money;
use Tests\Data\Pricing\ProductData;
use Tests\TestCase;

/**
 * @deprecated
 */
class CalculationParametersTest extends TestCase
{
    public function testShouldCalculateCostPrice(): void
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

        $expected = Money::BRL(108315);

        // Act
        $result = $calculationParameters->costPrice();

        // Assert
        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals($expected, $result);
    }
}
