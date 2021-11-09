<?php

namespace Src\Sales\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Sales\Domain\Contracts\Repository\ErpRepository;
use Src\Sales\Domain\Contracts\UseCases\ListSales;
use Src\Sales\Application\UseCases\ListSales as ListSalesImpl;
use Src\Sales\Infrastructure\Bling\Repository;

class SalesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(ErpRepository::class, Repository::class);

        $this->app->bind(ListSales::class, ListSalesImpl::class);
    }
}
