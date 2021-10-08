<?php

namespace Src\Prices\Application\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Application\Listeners\SendUnprofitablePriceNotification;
use Src\Prices\Domain\Price\Events\UnprofitablePrice;
use Src\Prices\Domain\Price\Models\Observers\PriceObserver;
use Src\Prices\Domain\Price\Models\Price;

class PricingEventServiceProvider extends ServiceProvider
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
