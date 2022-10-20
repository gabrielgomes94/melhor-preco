<?php

namespace Src\Sales\Application\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSalesTest;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplaceSalesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_get_sales(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);
        $marketplace = MarketplaceData::shopee($user);

        /** @var MarketplaceSalesRepository $repository */
        $repository = app(MarketplaceSalesRepository::class);

        // Act
        $result = $repository->getSales($marketplace);

        // Assert
        $this->assertInstanceOf(MarketplaceSalesTest::class, $result);
        $this->assertSame(3, $result->getSalesCount());
        $this->assertSame(2539.5, $result->getTotalValue());
    }

    public function test_should_get_sales_by_product(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);
        $marketplace = MarketplaceData::shopee($user);
        $product = ProductData::babyCarriage($user);

        /** @var MarketplaceSalesRepository $repository */
        $repository = app(MarketplaceSalesRepository::class);

        // Act
        $result = $repository->getSalesByProduct($product, $marketplace);

        // Assert
        $this->assertInstanceOf(MarketplaceSalesTest::class, $result);
        $this->assertSame(2, $result->getSalesCount());
        $this->assertSame(2499.7, $result->getTotalValue());
    }
}
