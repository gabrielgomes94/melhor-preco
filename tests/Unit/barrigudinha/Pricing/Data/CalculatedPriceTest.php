<?php

namespace Tests\Unit\Barrigudinha\Pricing\Data;

use Barrigudinha\Pricing\Data\CalculatedPrice;
use Money\Money;
use Tests\TestCase;

class CalculatedPriceTest extends TestCase
{
    public function testShouldInstantiate()
    {
        // Set
        $price = Money::BRL(1000);
        $costs = Money::BRL(800);

        $expected = [
            'suggestedPrice' => '10.00',
            'costs' => '8.00',
            'profit' => '2.00',
            'margin' => 20.0,
        ];

        // Actions
        $result = new CalculatedPrice($price, $costs);

        // Assertions
        $this->assertInstanceOf(CalculatedPrice::class, $result);
        $this->assertSame($expected, $result->toArray());
    }
}
