<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Calculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Math\Percentage;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculateWithDiscountTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_price_calculated_with_discount(): void
    {
        // Arrange
        /** @var CalculateWithDiscount $calculateWithDiscount */
        $calculateWithDiscount = app(CalculateWithDiscount::class);

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        ProductData::babyCarriage($user, [
            $price = PriceData::build($marketplace, ['value' => 899.9])
        ]);

        // Act
        $result = $calculateWithDiscount->get($price, Percentage::fromPercentage(10));

        // Assert
        $this->assertSame(809.91, $result->get());
        $this->assertSame(97.19, $result->getCommission());
        $this->assertSame(181.28, $result->getProfit());
    }
}
