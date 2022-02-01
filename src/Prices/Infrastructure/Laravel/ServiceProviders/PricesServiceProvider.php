<?php

namespace Src\Prices\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider as ServiceProviderAlias;
use Src\Prices\Application\UseCases\ShowPrice;
use Src\Prices\Domain\UseCases\Contracts\ShowPrice as ShowPriceInterface;

class PricesServiceProvider extends ServiceProviderAlias
{
    public function boot()
    {
        $this->app->bind(ShowPriceInterface::class, ShowPrice::class);
    }
}
