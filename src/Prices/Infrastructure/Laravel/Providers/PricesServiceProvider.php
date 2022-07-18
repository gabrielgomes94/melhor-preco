<?php

namespace Src\Prices\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider as ServiceProviderAlias;
use Src\Prices\Domain\Services\Price\SynchronizePrices as SynchronizePricesInterface;
use Src\Prices\Infrastructure\Laravel\Services\Prices\SynchronizePrices;

class PricesServiceProvider extends ServiceProviderAlias
{
    public function boot()
    {
        // Use Cases
        $this->app->bind(SynchronizePricesInterface::class, SynchronizePrices::class);
    }
}
