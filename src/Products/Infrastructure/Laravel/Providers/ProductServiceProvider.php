<?php

namespace Src\Products\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Domain\Repositories\Erp\CategoryRepository as ErpCategoryRepository;
use Src\Products\Domain\Repositories\Erp\ProductRepository as ErpProductRepository;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Domain\UseCases\SyncCategories;
use Src\Products\Infrastructure\Bling\CategoryRepository as BlingCategoryRepositoryImpl;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingProductRepositoryImpl;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Infrastructure\Laravel\Models\Categories\CategoryObserver;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository as CategoryRepositoryImpl;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository as ProductRepositoryImpl;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeCategories;

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
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryImpl::class);

        $this->app->bind(ErpCategoryRepository::class, BlingCategoryRepositoryImpl::class);
        $this->app->bind(ErpProductRepository::class, BlingProductRepositoryImpl::class);

    }

    private function bindServices(): void
    {
        $this->app->bind(SyncCategories::class, SynchronizeCategories::class);
    }
}
