<?php

namespace Src\Prices\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider as ServiceProviderAlias;
use Src\Prices\Application\UseCases\ShowPrice;
use Src\Prices\Application\UseCases\SynchronizePrices;
use Src\Prices\Domain\UseCases\Contracts\ShowPrice as ShowPriceInterface;
use Src\Prices\Domain\UseCases\Contracts\SynchronizePrices as SynchronizePricesInterface;

class PricesServiceProvider extends ServiceProviderAlias
{
    public function boot()
    {
        // Use Cases
        $this->app->bind(ShowPriceInterface::class, ShowPrice::class);
        $this->app->bind(SynchronizePricesInterface::class, SynchronizePrices::class);
    }
}
