<?php

namespace Src\Prices\Calculator\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Prices\Calculator\Application\Services\SimulatePostService;
use Src\Prices\Calculator\Application\UseCases\CalculatePrice;
use Src\Prices\Calculator\Domain\Services\Contracts\SimulatePost as SimulatePostInterface;
use Src\Prices\Calculator\Domain\UseCases\Contracts\CalculatePrice as CalculatePriceInterface;

class CalculatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Services
        $this->app->bind(SimulatePostInterface::class, SimulatePostService::class);

        // Use Cases
        $this->app->bind(CalculatePriceInterface::class, CalculatePrice::class);
    }
}
