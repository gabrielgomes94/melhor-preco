<?php

namespace Src\Prices\Infrastructure\Laravel\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Prices\Domain\Events\PriceSynchronized;
use Src\Prices\Domain\Events\PriceWasNotSynchronized;
use Src\Prices\Domain\Events\UnprofitablePrice;
use Src\Prices\Infrastructure\Laravel\Logging\Listeners\LogPriceSynchronized;
use Src\Prices\Infrastructure\Laravel\Logging\Listeners\LogPriceWasNotSynchronized;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Prices\Infrastructure\Laravel\Models\PriceObserver;
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
        Price::observe(PriceObserver::class);

        Event::listen(
            UnprofitablePrice::class,
            SendUnprofitablePriceNotification::class
        );

        Event::listen(
            PriceSynchronized::class,
            LogPriceSynchronized::class
        );

        Event::listen(
            PriceWasNotSynchronized::class,
            LogPriceWasNotSynchronized::class
        );
    }
}
