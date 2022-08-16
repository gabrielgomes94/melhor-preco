<?php

namespace Src\Products\Infrastructure\Laravel\Providers;

//use PHPUnit\Framework\TestCase;

use Src\Products\Domain\Repositories\CategoryRepository as CategoryRepositoryInterface;
use Src\Products\Domain\Repositories\Erp\CategoryRepository as ErpCategoryRepositoryInterface;
use Src\Products\Domain\Repositories\Erp\ProductRepository as ErpProductRepositoryInterface;
use Src\Products\Domain\Repositories\ProductRepository as ProductRepositoryInterface;
use Src\Products\Domain\Services\SyncCategories as SyncCategoriesInterface;
use Src\Products\Domain\Services\SyncProductCosts as SyncProductCostsInterface;
use Src\Products\Domain\Services\SyncProducts as SyncProductsInterface;
use Src\Products\Domain\Services\UploadImages as UploadImagesInterface;
use Src\Products\Infrastructure\Bling\CategoryRepository as ErpCategoryRepository;
use Src\Products\Infrastructure\Bling\ProductRepository as ErpProductRepository;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeCategories;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProductCosts;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProducts;
use Src\Products\Infrastructure\Laravel\Services\UploadImages;
use Tests\TestCase;

class ProductServiceProviderTest extends TestCase
{
    public function test_should_bind_repositories(): void
    {
        // Act
        $categoryRepository = $this->app->get(CategoryRepositoryInterface::class);
        $productRepository = $this->app->get(ProductRepositoryInterface::class);
        $categoryErpRepository = $this->app->get(ErpCategoryRepositoryInterface::class);
        $productErpRepository = $this->app->get(ErpProductRepositoryInterface::class);

        // Assert
        $this->assertInstanceOf(CategoryRepository::class, $categoryRepository);
        $this->assertInstanceOf(ProductRepository::class, $productRepository);
        $this->assertInstanceOf(ErpCategoryRepository::class, $categoryErpRepository);
        $this->assertInstanceOf(ErpProductRepository::class, $productErpRepository);
    }

    public function test_should_bind_services(): void
    {
        // Act
        $syncCategoriesService = $this->app->get(SyncCategoriesInterface::class);
        $syncProductsService = $this->app->get(SyncProductsInterface::class);
        $syncProductCostsService = $this->app->get(SyncProductCostsInterface::class);
        $uploadImagesService = $this->app->get(UploadImagesInterface::class);

        // Assert
        $this->assertInstanceOf(SynchronizeCategories::class, $syncCategoriesService);
        $this->assertInstanceOf(SynchronizeProducts::class, $syncProductsService);
        $this->assertInstanceOf(SynchronizeProductCosts::class, $syncProductCostsService);
        $this->assertInstanceOf(UploadImages::class, $uploadImagesService);
    }
}
