<?php

namespace Src\Products\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Domain\Repositories\Erp\CategoryRepository as ErpCategoryRepository;
use Src\Products\Domain\Repositories\Erp\ProductRepository as ErpProductRepository;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository as ProductRepositoryImpl;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository as CategoryRepositoryImpl;
use Src\Products\Infrastructure\Bling\CategoryRepository as BlingCategoryRepositoryImpl;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingProductRepositoryImpl;

class RepositoryServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(ProductRepository::class, ProductRepositoryImpl::class);

        $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
        $this->app->bind(ErpCategoryRepository::class, BlingCategoryRepositoryImpl::class);
        $this->app->bind(ErpProductRepository::class, BlingProductRepositoryImpl::class);
    }
}
