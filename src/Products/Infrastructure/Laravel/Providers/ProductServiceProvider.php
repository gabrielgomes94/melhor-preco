<?php

namespace Src\Products\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
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
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Models\Categories\CategoryObserver;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeCategories;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProductCosts;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProducts;
use Src\Products\Infrastructure\Laravel\Services\UploadImages;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);

        $this->bindRepositories();
        $this->bindServices();
    }

    private function bindRepositories(): void
    {
        // DB Repositories
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        // ERP Repositories
        $this->app->bind(ErpCategoryRepositoryInterface::class, ErpCategoryRepository::class);
        $this->app->bind(ErpProductRepositoryInterface::class, ErpProductRepository::class);
    }

    private function bindServices(): void
    {
        $this->app->bind(SyncCategoriesInterface::class, SynchronizeCategories::class);
        $this->app->bind(SyncProductsInterface::class, SynchronizeProducts::class);
        $this->app->bind(SyncProductCostsInterface::class, SynchronizeProductCosts::class);
        $this->app->bind(UploadImagesInterface::class, UploadImages::class);
    }
}
