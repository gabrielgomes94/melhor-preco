<?php

namespace Src\Prices\Infrastructure\Laravel\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Domain\Events\UnprofitablePrice;
use Src\Prices\Infrastructure\Laravel\Services\Notifications\SendUnprofitablePriceNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            UnprofitablePrice::class,
            SendUnprofitablePriceNotification::class
        );
    }
}
