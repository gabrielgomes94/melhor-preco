<?php

namespace Src\Products\Infrastructure\Laravel\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Products\Domain\Repositories\CategoryRepository;
use Src\Products\Domain\Repositories\Erp\CategoryRepository as ErpCategoryRepository;
use Src\Products\Domain\Repositories\Erp\ProductRepository as ErpProductRepository;
use Src\Products\Domain\Repositories\PostRepository;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Domain\Repositories\ProductWithPriceRepository;
use Src\Products\Infrastructure\Laravel\Repositories\PostRepository as PostRepositoryImpl;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository as ProductRepositoryImpl;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository as CategoryRepositoryImpl;
use Src\Products\Infrastructure\Bling\CategoryRepository as BlingCategoryRepositoryImpl;
use Src\Products\Infrastructure\Bling\ProductRepository as BlingProductRepositoryImpl;
use Src\Products\Infrastructure\Laravel\Repositories\ProductWithPriceRepository as ProductWithPriceRepositoryImpl;

class RepositoryServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(PostRepository::class, PostRepositoryImpl::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryImpl::class);
        $this->app->bind(ProductWithPriceRepository::class, ProductWithPriceRepositoryImpl::class);

        $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
        $this->app->bind(ErpCategoryRepository::class, BlingCategoryRepositoryImpl::class);
        $this->app->bind(ErpProductRepository::class, BlingProductRepositoryImpl::class);
    }
}
