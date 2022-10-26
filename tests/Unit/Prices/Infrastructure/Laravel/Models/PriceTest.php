<?php

namespace Src\Prices\Infrastructure\Laravel\Models;


use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class PriceTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_price(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::shopee($user);

        // Act
        $instance = PriceData::persisted($product, $marketplace, ['value' => 899.90, 'profit' => '95.90']);

        // Assert
        $commission = $instance->getCommission();
        $this->assertEquals(10.0, $commission->get());

        $this->assertIsString($instance->getId());
        $this->assertInstanceOf(Carbon::class, $instance->getLastUpdate());

        $margin = $instance->getMargin();
        $this->assertSame(10.66, round($margin->get(), 2));

        $this->assertEquals($marketplace, $instance->getMarketplace());
        $this->assertEquals($product, $instance->getProduct());
        $this->assertSame('1234', $instance->getProductSku());
        $this->assertSame(95.9, $instance->getProfit());
        $this->assertSame('3213123', $instance->getStoreSkuId());
        $this->assertSame(899.9, $instance->getValue());
        $this->assertTrue($instance->isProfitable());
    }

    public function test_should_instantiate_price_without_profit_value(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::shopee($user);

        // Act
        $instance = PriceData::persisted($product, $marketplace, ['value' => 899.90, 'profit' => null]);

        // Assert
        $this->assertNull($instance->getProfit());
        $this->assertNull($instance->getMargin());
        $this->assertFalse($instance->isProfitable());
    }

    public function test_prices_relationships(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyCarriage($user);
        $marketplace = MarketplaceData::shopee($user);

        // Act
        $instance = PriceData::persisted($product, $marketplace, ['value' => 899.90, 'profit' => '95.90']);

        // Assert
        $this->assertInstanceOf(Marketplace::class, $instance->marketplace);
        $this->assertInstanceOf(Product::class, $instance->product);
    }
}
