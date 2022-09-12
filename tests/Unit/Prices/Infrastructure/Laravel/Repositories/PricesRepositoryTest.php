<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class PricesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_count(): void
    {
        // Arrange
        $user = UserData::make();

        $marketplace = MarketplaceData::shopee($user);
        ProductData::babyCarriage($user, [PriceData::build($marketplace)]);
        ProductData::babyChair($user, [PriceData::build($marketplace)]);
        $repository = new PricesRepository();

        // Act
        $result = $repository->count($user->getId());

        // Assert
        $this->assertSame(2, $result);
    }

    public function test_should_get_last_synchronization_date_time(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        ProductData::babyCarriage($user, [PriceData::build($marketplace)]);
        ProductData::babyChair($user, [PriceData::build($marketplace)]);
        $repository = new PricesRepository();

        // Act
        $result = $repository->getLastSynchronizationDateTime($user->getId());

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
    }

    public function test_should_insert(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user);
        $price = new Price([
            'value' => '799.90',
            'store_sku_id' => '12334567899',
            'additional_costs' => 0.0,
        ]);
        $repository = new PricesRepository();

        // Act
        $result = $repository->insert($price, $product, $marketplace, 10.0, 80.0);

        // Assert
        $this->assertTrue($result);
        $this->assertCount(1, Price::query()->get());
    }

    public function test_should_update(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user);
        $price = PriceData::persisted($product, $marketplace);
        $repository = new PricesRepository();

        // Act
        $result = $repository->update($price, 1000.0, 120.0, 10.0);

        // Assert
        $this->assertTrue($result);

        $price = $price->refresh();
        $this->assertSame(1000.0, $price->getValue());
        $this->assertSame(120.0, $price->getProfit());
        $this->assertSame(10.0, $price->getCommission()->get());
    }
}
