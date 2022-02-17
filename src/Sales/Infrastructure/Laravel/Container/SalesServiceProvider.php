<?php

namespace Src\Sales\Infrastructure\Laravel\Container;

use Illuminate\Support\ServiceProvider;
use Src\Sales\Application\UseCases\SyncSales as SyncSalesImpl;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;
use Src\Sales\Domain\UseCases\Contracts\ListSales;
use Src\Sales\Application\UseCases\ListSales as ListSalesImpl;
use Src\Sales\Domain\UseCases\Contracts\SyncSales;
use Src\Sales\Infrastructure\Bling\Repository;

class SalesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(ErpRepository::class, Repository::class);

        // Use Cases
        $this->app->bind(ListSales::class, ListSalesImpl::class);
        $this->app->bind(SyncSales::class, SyncSalesImpl::class);
    }
}
