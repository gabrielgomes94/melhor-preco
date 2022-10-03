<?php

namespace Src\Prices\Domain\DataTransfer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Marketplace;
use Tests\Data\Domain\Prices\CalculatedPriceData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ListPricesCalculatedTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_make_an_instance(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);

        $price_1 = PriceData::persisted(
            ProductData::babyCarriage($user),
            $marketplace
        );
        $calculatedPrice_1  = CalculatedPriceData::babyCarriage();

        $price_2 = PriceData::persisted(
            ProductData::babyChair($user),
            $marketplace
        );
        $calculatedPrice_2  = CalculatedPriceData::babyChair();

        // Act
        $instance = new ListPricesCalculated(
            $marketplace,
            [
                PriceCalculatedFromProduct::fromPrice($price_1, $calculatedPrice_1),
                PriceCalculatedFromProduct::fromPrice($price_2, $calculatedPrice_2),
            ]
        );

        // Assert
        $this->assertInstanceOf(Marketplace::class, $instance->marketplace);
        $this->assertContainsOnlyInstancesOf(PriceCalculatedFromProduct::class, $instance->calculatedPrices);
        $this->assertCount(2, $instance->calculatedPrices);
    }
}
