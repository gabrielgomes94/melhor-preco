<?php

namespace Tests\Integration\Products\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\DataTransfer\FilterOptions;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product as ProductModel;
use Src\Users\Infrastructure\Laravel\Models\User;
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
        $this->actingAs($user);
        ProductData::makePersisted($user);
        ProductData::makePersisted($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->all();

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(2, count($result));
    }

    public function test_should_list_all_products_with_sku_filter_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['sku' => '100']);
        ProductData::makePersisted($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->allFiltered(new FilterOptions(sku: '100'));

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(1, count($result));
    }

    public function test_should_list_all_products_with_category_filter_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['category_id' => '123']);
        ProductData::makePersisted($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->allFiltered(new FilterOptions(category: '123'));

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(1, count($result));
    }

    public function test_should_get_product_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['sku' => '1234']);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->get('1234');

        // Assert
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_should_not_get_product_from_user(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->get('1234');

        // Assert
        $this->assertNull($result);
    }

    public function test_should_get_last_synchronization_date_time(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['sku' => '1234']);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->getLastSynchronizationDateTime('1234');

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
    }

    public function test_should_count_products(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['sku' => '1234']);
        ProductData::makePersisted($user);
        ProductData::makePersisted($user, ['is_active' => false]);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->count('1234');

        // Assert
        $this->assertSame(3, $result);
    }

    public function test_should_count_active_products(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['sku' => '1234']);
        ProductData::makePersisted($user);
        ProductData::makePersisted($user, ['is_active' => false]);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->countActives('1234');

        // Assert
        $this->assertSame(2, $result);
    }

    public function test_should_get_product_by_ean(): void
    {
        // Arrange
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['ean' => '123456789']);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->getProductByEan('123456789');

        // Assert
        $this->assertInstanceOf(Product::class, $result);
    }

    public function test_should_get_products_and_variation(): void
    {
        $user = UserData::make();
        $this->actingAs($user);
        ProductData::makePersisted($user, ['ean' => '123456789', 'sku' => '100']);
        ProductData::makePersisted($user, ['ean' => '123456789', 'parent_sku' => '100', 'sku' => '101']);
        ProductData::makePersisted($user, ['ean' => '123456789', 'parent_sku' => '100', 'sku' => '102']);
        ProductData::makePersisted($user, ['ean' => '123456789', 'sku' => '99']);
        ProductData::makePersisted($user, ['ean' => '123456789', 'sku' => '88']);
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->getProductsAndVariations('100');

        // Assert
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
        $this->assertSame(3, count($result));
    }

    public function test_should_update_costs(): void
    {
        $user = UserData::make();
        $this->actingAs($user);
        $product = ProductData::makePersisted(
            $user,
            [
                'purchase_price' => 100.0,
                'additional_costs' => 5.0,
                'tax_icms' => 4,
                'sku' => '100',
            ]);
        $repository = $this->app->get(ProductRepository::class);
        $costs = new Costs(105.0, 5.5, 8);

        // Act
        $result = $repository->updateCosts($product, $costs);

        // Assert
        $product = ProductModel::where('sku', '100')->first();
        $this->assertSame(105.0, $product->getCosts()->purchasePrice());
        $this->assertSame(5.5, $product->getCosts()->additionalCosts());
        $this->assertSame(8.0, $product->getCosts()->taxICMS());
    }

    public function test_should_save()
    {
        $user = UserData::make();
        $this->actingAs($user);
        $product = ProductData::make();
        $repository = $this->app->get(ProductRepository::class);

        // Act
        $result = $repository->save($product, $user->id);

        // Assert
        $this->assertTrue($result);

        $product = $product->refresh();
        $this->assertSame($user->id, $product->user_id);
    }
}