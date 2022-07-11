<?php

namespace Src\Sales\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Sales\Domain\Repositories\SaleItemsRepository;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Infrastructure\Bling\Repository;
use Src\Sales\Infrastructure\Laravel\Repositories\SaleItemsRepository as ItemRepositoryImpl;
use Src\Sales\Infrastructure\Laravel\Repositories\SaleOrderRepository;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Repositories
        $this->app->bind(ErpRepository::class, Repository::class);
        $this->app->bind(SaleItemsRepository::class, ItemRepositoryImpl::class);
        $this->app->bind(SaleOrderRepositoryInterface::class, SaleOrderRepository::class);
    }
}
