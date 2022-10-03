<?php

namespace Src\Prices\Infrastructure\Laravel\Services\MassCalculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculateFromMarkupTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_price_calculated_from_markup(): void
    {
        // Arrange
        /** @var CalculateFromMarkup $calculateFromMarkup */
        $calculateFromMarkup = app(CalculateFromMarkup::class);

        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        ProductData::babyCarriage($user, [
            $price = PriceData::build($marketplace, ['value' => 899.9])
        ]);

        // Act
        $result = $calculateFromMarkup->get($price, 2.5);

        // Assert
        $this->assertSame(1218.25, $result->get());
        $this->assertSame(100.00, $result->getCommission());
        $this->assertSame(564.56, $result->getProfit());
    }
}
