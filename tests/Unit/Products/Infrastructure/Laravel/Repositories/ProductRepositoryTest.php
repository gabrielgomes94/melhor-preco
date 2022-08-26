<?php

namespace Src\Products\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\Product;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product as ProductModel;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function test_should_list_all_products_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::babyCarriage($user);
        ProductData::babyChair($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->all($user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(2, count($result));
    }

    public function test_should_list_all_products_with_sku_filter_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::babyCarriage($user);
        ProductData::babyChair($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->allFiltered(new FilterOptions(sku: '1234'), $user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(1, count($result));
    }

    public function test_should_list_all_products_with_category_filter_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        $category = CategoryData::babyCarriage($user);
        ProductData::babyCarriage($user, [], $category);
        ProductData::babyChair($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->allFiltered(new FilterOptions(category: '10'), $user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(1, count($result));
    }

    public function test_should_get_product_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::babyCarriage($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->get('1234', $user->getId());

        // Assert
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_should_not_get_product_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->get('1234', $user->getId());

        // Assert
        $this->assertNull($result);
    }

    public function test_should_get_last_synchronization_date_time(): void
    {
        // Arrange
        $user = UserData::make();

        ProductData::babyCarriage($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->getLastSynchronizationDateTime($user->getId());

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
    }

    public function test_should_count_products(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::babyCarriage($user);
        ProductData::babyChair($user);
        ProductData::babyPacifier($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->count($user->getId());

        // Assert
        $this->assertSame(3, $result);
    }

    public function test_should_count_active_products(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::babyCarriage($user);
        ProductData::babyChair($user);
        ProductData::babyPacifier($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->countActives($user->getId());

        // Assert
        $this->assertSame(2, $result);
    }

    public function test_should_get_product_by_ean(): void
    {
        // Arrange
        $user = UserData::make();
        ProductData::babyCarriage($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->getProductByEan('7908238800092', $user->getId());

        // Assert
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_should_get_products_and_variation(): void
    {
        $user = UserData::make();
        ProductData::babyCarriage($user);
        ProductData::babyChair($user);
        ProductData::babyPacifier($user);
        ProductData::blanket($user);
        ProductData::redBlanket($user);
        ProductData::blueBlanket($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->getProductsAndVariations('821', $user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(3, count($result));
    }

    public function test_should_update_costs(): void
    {
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $repository = $this->app->get(ProductRepository::class);
        $costs = new Costs(105.0, 5.5, 8);

        // Act
        $repository->updateCosts($product, $costs, $user->getId());

        // Assert
        $product = ProductModel::where('sku', '1234')->first();
        $this->assertSame(105.0, $product->getCosts()->purchasePrice());
        $this->assertSame(5.5, $product->getCosts()->additionalCosts());
        $this->assertSame(8.0, $product->getCosts()->taxICMS());
    }

    public function test_should_save()
    {
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->save($product, $user->getId());

        // Assert
        $this->assertTrue($result);

        $product = $product->refresh();
        $this->assertSame($user->id, $product->user_id);
    }
}
