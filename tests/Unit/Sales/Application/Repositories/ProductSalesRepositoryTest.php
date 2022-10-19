<?php

namespace Src\Sales\Application\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductSalesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_count(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        $product = ProductData::babyCarriage($user);

        /** @var ProductSalesRepository $repository */
        $repository = app(ProductSalesRepository::class);

        // Act
        $result = $repository->count($product);

        // Assert
        $this->assertSame(2, $result);
    }

    public function test_should_get_items_selled(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);
        $product = ProductData::babyCarriage($user);

        /** @var ProductSalesRepository $repository */
        $repository = app(ProductSalesRepository::class);

        // Act
        $result = $repository->getItemsSelled($product);

        // Assert
        $this->assertContainsOnlyInstancesOf(Item::class, $result);
        $this->assertCount(2, $result);
    }
}
