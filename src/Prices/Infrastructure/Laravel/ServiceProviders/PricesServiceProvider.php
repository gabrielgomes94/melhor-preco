<?php

namespace Src\Prices\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider as ServiceProviderAlias;
use Src\Prices\Application\UseCases\GetPost;
use Src\Prices\Application\UseCases\SynchronizePrices;
use Src\Prices\Domain\UseCases\Contracts\GetPost as GetPostInterface;
use Src\Prices\Domain\UseCases\Contracts\SynchronizePrices as SynchronizePricesInterface;

class PricesServiceProvider extends ServiceProviderAlias
{
    public function boot()
    {
        // Use Cases
        $this->app->bind(GetPostInterface::class, GetPost::class);
        $this->app->bind(SynchronizePricesInterface::class, SynchronizePrices::class);
    }
}
