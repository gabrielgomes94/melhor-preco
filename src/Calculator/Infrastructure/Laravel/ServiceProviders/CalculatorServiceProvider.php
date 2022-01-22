<?php

namespace Src\Calculator\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Calculator\Application\Services\SimulatePostService;
use Src\Calculator\Application\UseCases\CalculatePrice;
use Src\Calculator\Domain\Services\Contracts\SimulatePost as SimulatePostInterface;
use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice as CalculatePriceInterface;

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
