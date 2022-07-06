<?php

namespace Tests\Integration\Marketplaces\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValue;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_make_marketplace_model(): void
    {
        // Arrange
        $expectedCommission = Commission::fromArray(
            'uniqueCommission',
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(12.8))
            ])
        );
        $user = UserData::make(['id' => 1]);

        // Act
        $result = MarketplaceData::persisted($user);

        // Assert
        $this->assertSame('123456', $result->getErpId());
        $this->assertEquals($expectedCommission, $result->getCommission());
        $this->assertSame('Magalu', $result->getName());
        $this->assertSame('magalu', $result->getSlug());
        $this->assertInstanceOf(User::class, $result->getUser());
        $this->assertTrue($result->isActive());
        $this->assertFalse($result->slugsExists());
        $this->assertSame('1', $result->getUserId());
    }

    public function test_should_get_prices_relationship(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::persisted($user);
        $marketplace->prices()->saveMany([
            PriceData::persisted($user),
            PriceData::persisted($user, ['store_sku_id' => '3213123']),
        ]);

        // Act
        $result = $marketplace->prices;

        // Assert
        $this->assertContainsOnlyInstancesOf(Price::class, $result->all());
        $this->assertCount(2, $result->all());
    }

    public function test_should_get_products_relationship(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::persisted($user);
        ProductData::makePersisted($user, ['sku' => '1211']);
        $marketplace->prices()->saveMany([
            PriceData::persisted($user),
            PriceData::persisted($user, ['store_sku_id' => '3213123']),
        ]);

        // Act
        $result = $marketplace->products;

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result->all());
        $this->assertCount(2, $result->all());
    }

    public function test_should_get_user_relationship(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::persisted($user);

        // Act
        $result = $marketplace->user;

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    public function test_should_set_commission(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::persisted($user);

        // Act
        $marketplace->setCommissions(
            new CommissionValuesCollection([
                new CommissionValue(Percentage::fromPercentage(10.8)),
            ])
        );

        // Assert
        $commission = $marketplace->getCommission()->get();
        $this->assertSame(10.8, $commission->get());
    }

    public function test_should_query_by_erp_id(): void
    {
        // Arrange
        $user = UserData::make();
        MarketplaceData::persisted($user, [
            'erp_id' => '123456789'
        ]);

        // Act
        $result = Marketplace::withErpId('123456789');

        // Assert
        $this->assertInstanceOf(Builder::class, $result);
        $this->assertInstanceOf(Marketplace::class, $result->first());
    }

    public function test_should_query_by_user_id(): void
    {
        // Arrange
        $user = UserData::make(['id' => 1]);
        MarketplaceData::persisted($user, [
            'erp_id' => '123456789'
        ]);

        // Act
        $result = Marketplace::withUser('1');

        // Assert
        $this->assertInstanceOf(Builder::class, $result);
        $this->assertInstanceOf(Marketplace::class, $result->first());
    }

    public function test_should_query_by_slug(): void
    {
        // Arrange
        $user = UserData::make();
        MarketplaceData::persisted($user, [
            'name' => 'Magalu'
        ]);

        // Act
        $result = Marketplace::withSlug('magalu');

        // Assert
        $this->assertInstanceOf(Builder::class, $result);
        $this->assertInstanceOf(Marketplace::class, $result->first());
    }
}
