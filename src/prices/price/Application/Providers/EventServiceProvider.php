<?php

namespace Src\Prices\Price\Application\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Price\Application\Listeners\SendUnprofitablePriceNotification;
use Src\Prices\Price\Domain\Events\UnprofitablePrice;
use Src\Prices\Price\Domain\Models\PriceObserver;
use Src\Prices\Price\Domain\Models\Price;

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
        Price::observe(PriceObserver::class);

        Event::listen(
            UnprofitablePrice::class,
            SendUnprofitablePriceNotification::class
        );
    }
}