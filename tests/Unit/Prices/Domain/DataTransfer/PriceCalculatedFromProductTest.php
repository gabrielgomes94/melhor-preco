<?php

namespace Src\Prices\Domain\DataTransfer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Products\Domain\Models\Product;
use Tests\Data\Domain\Prices\CalculatedPriceData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class PriceCalculatedFromProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_make_an_instance(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user);
        $calculatedPrice = CalculatedPriceData::babyCarriage();

        // Act
        $instance = new PriceCalculatedFromProduct(
            $product,
            $marketplace,
            $calculatedPrice,
        );

        // Assert
        $this->assertInstanceOf(Product::class, $instance->product);
        $this->assertSame($product, $instance->product);
        $this->assertInstanceOf(Marketplace::class, $instance->marketplace);
        $this->assertSame($marketplace, $instance->marketplace);
        $this->assertInstanceOf(CalculatedPrice::class, $instance->calculatedPrice);
        $this->assertSame($calculatedPrice, $instance->calculatedPrice);
    }

    public function test_should_make_an_instance_from_price(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user);
        $price = PriceData::persisted($product, $marketplace);
        $calculatedPrice  = CalculatedPriceData::babyCarriage();

        // Act
        $instance = PriceCalculatedFromProduct::fromPrice($price, $calculatedPrice);

        // Assert
        $this->assertInstanceOf(Product::class, $instance->product);
        $this->assertInstanceOf(Marketplace::class, $instance->marketplace);
        $this->assertInstanceOf(CalculatedPrice::class, $instance->calculatedPrice);
    }
}
