<?php

namespace Src\Sales\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Domain\Repositories\SaleItemsRepository;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Infrastructure\Laravel\Repositories\SaleSaleItemsRepository as ItemRepositoryImpl;
use Src\Sales\Infrastructure\Laravel\Repositories\SaleOrderRepository;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Repositories
        $this->app->bind(SaleItemsRepository::class, ItemRepositoryImpl::class);
        $this->app->bind(SaleOrderRepositoryInterface::class, SaleOrderRepository::class);
    }
}
