<?php

namespace Src\Products\Infrastructure\ServiceProviders;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Products\Domain\Repositories\Contracts\CategoryRepository;
use Src\Products\Domain\Repositories\Contracts\ErpCategoryRepository;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Products\Infrastructure\Eloquent\Repositories\ProductRepository as ProductRepositoryImpl;
use Src\Products\Infrastructure\Eloquent\Repositories\CategoryRepository as CategoryRepositoryImpl;
use Src\Products\Infrastructure\Bling\CategoryRepository as BlingCategoryRepositoryImpl;

class RepositoryServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(ProductRepository::class, ProductRepositoryImpl::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
        $this->app->bind(ErpCategoryRepository::class, BlingCategoryRepositoryImpl::class);
    }
}
