<?php

namespace Src\Prices\Infrastructure\Laravel\Services\MassCalculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Math\Percentage;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculateWithAdditionTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_price_calculated_with_addition(): void
    {
        // Arrange
        /** @var CalculateWithAddition $calculateWithAddition */
        $calculateWithAddition = app(CalculateWithAddition::class);

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        ProductData::babyCarriage($user, [
            $price = PriceData::build($marketplace, ['value' => 899.9])
        ]);

        // Act
        $result = $calculateWithAddition->get($price, Percentage::fromPercentage(10));

        // Assert
        $this->assertSame(989.89, $result->get());
        $this->assertSame(100.00, $result->getCommission());
        $this->assertSame(348.64, $result->getProfit());
    }
}
