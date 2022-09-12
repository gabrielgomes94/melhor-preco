<?php

namespace Src\Prices\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Prices\Domain\Repositories\PricesRepository as PricesRepositoryInterface;
use Src\Prices\Domain\Repositories\ProductsRepository as ProductsRepositoryInterface;
use Src\Prices\Domain\Services\CalculatePriceFromProduct as CalculatePriceFromProductInterface;
use Src\Prices\Domain\Services\MassCalculatePrices as MassCalculatePricesInterface;
use Src\Prices\Domain\Services\SynchronizeFromMarketplace as SynchronizeFromMarketplaceInterface;
use Src\Prices\Infrastructure\Laravel\Repositories\PricesRepository;
use Src\Prices\Infrastructure\Laravel\Repositories\ProductsRepository;
use Src\Prices\Infrastructure\Laravel\Services\CalculatePriceFromProduct;
use Src\Prices\Infrastructure\Laravel\Services\MassCalculatePrices;
use Src\Prices\Infrastructure\Laravel\Services\SynchronizeFromMarketplace;

class PricesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Repositories
        $this->app->bind(PricesRepositoryInterface::class, PricesRepository::class);
        $this->app->bind(ProductsRepositoryInterface::class, ProductsRepository::class);

        // Services
        $this->app->bind(CalculatePriceFromProductInterface::class, CalculatePriceFromProduct::class);
        $this->app->bind(MassCalculatePricesInterface::class, MassCalculatePrices::class);
        $this->app->bind(SynchronizeFromMarketplaceInterface::class, SynchronizeFromMarketplace::class);
    }
}
