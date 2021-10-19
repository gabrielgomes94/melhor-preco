<?php

namespace Src\Prices\Calculator\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Prices\Calculator\Application\Services\SimulatePostService;
use Src\Prices\Calculator\Domain\Contracts\Services\SimulatePost;

class CalculatorServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->app->bind(SimulatePost::class, SimulatePostService::class);
    }
}
