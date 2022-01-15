<?php

namespace Src\Products\Infrastructure\Eloquent;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Products\Domain\Repositories\Contracts\ProductRepository as ProductRepositoryInterface;
use Src\Products\Infrastructure\Eloquent\Repositories\ProductRepository;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}
