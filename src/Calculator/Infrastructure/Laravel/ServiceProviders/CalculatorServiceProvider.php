<?php

namespace Src\Calculator\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Calculator\Application\Services\CalculatePost;
use Src\Calculator\Application\UseCases\CalculatePrice;
use Src\Calculator\Domain\Services\Contracts\CalculatePost as CalculatePostInterface;
use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice as CalculatePriceInterface;

class CalculatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Services
        $this->app->bind(CalculatePostInterface::class, CalculatePost::class);

        // Use Cases
        $this->app->bind(CalculatePriceInterface::class, CalculatePrice::class);
    }
}
