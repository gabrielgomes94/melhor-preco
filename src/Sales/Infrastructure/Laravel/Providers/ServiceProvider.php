<?php

namespace Src\Sales\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Infrastructure\Bling\Repository as BlingRepository;
use Src\Sales\Application\Repositories\SaleOrderRepository;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Repositories
        $this->app->bind(ErpRepository::class, BlingRepository::class);
        $this->app->bind(SaleOrderRepositoryInterface::class, SaleOrderRepository::class);
    }
}
