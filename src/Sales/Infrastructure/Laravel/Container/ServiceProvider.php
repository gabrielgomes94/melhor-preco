<?php

namespace Src\Sales\Infrastructure\Laravel\Container;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Application\Services\GetProductSales;
use Src\Sales\Domain\Services\Contracts\GetProductSales as GetProductSalesInterface;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app->bind(GetProductSalesInterface::class, GetProductSales::class);
    }
}