<?php

namespace Src\Prices\Infrastructure\Laravel\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Domain\Models\Product;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;
use Src\Users\Domain\Models\User;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_list_products(): void
    {
        // Arrange
        $repository = new ProductsRepository();

        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $this->setupDatabase($marketplace, $user);
        $options = new Options(userId: $user->getId(), marketplace: $marketplace);

        // Act
        $result = $repository->list($options);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->items());
        $this->assertCount(6, $result->items());
    }

    public function test_should_list_products_when_options_has_profit_filters(): void
    {
        // Arrange
        $repository = new ProductsRepository();

        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $this->setupDatabase($marketplace, $user);
        $options = new Options(
            minimumProfit: 10.0,
            maximumProfit: 12.0,
            userId: $user->getId(),
            marketplace: $marketplace
        );

        // Act
        $result = $repository->list($options);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->items());
        $this->assertCount(2, $result->items());
    }

    public function test_should_list_products_when_options_has_categories(): void
    {
        // Arrange
        $repository = new ProductsRepository();

        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $this->setupDatabase($marketplace, $user);
        $options = new Options(
            categoryId: '10',
            userId: $user->getId(),
            marketplace: $marketplace
        );

        // Act
        $result = $repository->list($options);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->items());
        $this->assertCount(1, $result->items());

    }

    public function test_should_list_products_when_options_has_sku(): void
    {
        // Arrange
        $repository = new ProductsRepository();

        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $this->setupDatabase($marketplace, $user);
        $options = new Options(
            sku: '1234',
            userId: $user->getId(),
            marketplace: $marketplace
        );

        // Act
        $result = $repository->list($options);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->items());
        $this->assertCount(2, $result->items());
    }

    public function test_should_list_products_when_options_has_should_filter_kits(): void
    {
        // Arrange
        $repository = new ProductsRepository();

        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $this->setupDatabase($marketplace, $user);
        $options = new Options(
            filterKits: true,
            userId: $user->getId(),
            marketplace: $marketplace
        );

        // Act
        $result = $repository->list($options);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result->items());
        $this->assertCount(1, $result->items());
    }

    private function setupDatabase(Marketplace $marketplace, User $user): void
    {
        $category = CategoryData::babyCarriage($user);
        ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 899.0, 'profit' => 90.0])
            ],
            $category
        );
        ProductData::babyChair(
            $user,
            [
                PriceData::build($marketplace, ['value' => 599.0, 'profit' => 65.0])
            ]);
        ProductData::babyPacifier($user, [PriceData::build($marketplace)]);
        ProductData::blanket($user, [PriceData::build($marketplace)]);
        ProductData::redBlanket($user, [PriceData::build($marketplace)]);
        ProductData::blueBlanket($user, [PriceData::build($marketplace)]);
        ProductData::cradle($user, [PriceData::build($marketplace)]);
        ProductData::kitCradleAndCarriage($user, [PriceData::build($marketplace)]);
    }
}
