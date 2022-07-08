<?php

namespace Src\Sales\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Sales\Domain\Repositories\Contracts\ErpRepository;
use Src\Sales\Infrastructure\Bling\Repository;

class SalesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(ErpRepository::class, Repository::class);

        // Use Cases
//        $this->app->bind(SyncSales::class, SyncSalesImpl::class);
    }
}
