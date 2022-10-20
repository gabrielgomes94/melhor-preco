<?php

namespace Src\Sales\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Application\Repositories\MarketplaceSalesRepository;
use Src\Sales\Application\Repositories\ProductSalesRepository;
use Src\Sales\Domain\Repositories\ErpRepository;
use Src\Sales\Domain\Repositories\MarketplaceSalesRepository as MarketplaceSalesRepositoryInterface;
use Src\Sales\Domain\Repositories\ProductSalesRepository as ProductSalesRepositoryInterface;
use Src\Sales\Domain\Repositories\SaleOrderRepository as SaleOrderRepositoryInterface;
use Src\Sales\Domain\Services\CalculateItem as CalculateItemInterface;
use Src\Sales\Infrastructure\Bling\Repository as BlingRepository;
use Src\Sales\Application\Repositories\SaleOrderRepository;
use Src\Sales\Infrastructure\Laravel\Services\CalculateItem;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Repositories
        $this->app->bind(ErpRepository::class, BlingRepository::class);
        $this->app->bind(SaleOrderRepositoryInterface::class, SaleOrderRepository::class);

        $this->app->bind(
            MarketplaceSalesRepositoryInterface::class,
            MarketplaceSalesRepository::class,
        );
        $this->app->bind(
            ProductSalesRepositoryInterface::class,
            ProductSalesRepository::class
        );

        // Services
        $this->app->bind(CalculateItemInterface::class , CalculateItem::class);
    }
}
