<?php

namespace Src\Products\Application\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Products\Application\Listeners\LogProductsSynchronized;
use Src\Products\Application\Listeners\LogProductSynchronized;
use Src\Products\Application\Listeners\LogProductWasNotSynchronized;
use Src\Products\Application\Listeners\SendProductsSynchronizedNotification;
use Src\Products\Domain\Events\Product\ProductsSynchronized;
use Src\Products\Domain\Events\Product\ProductSynchronized;
use Src\Products\Domain\Events\Product\ProductWasNotSynchronized;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(
            ProductsSynchronized::class,
            LogProductsSynchronized::class
        );

        Event::listen(
            ProductsSynchronized::class,
            SendProductsSynchronizedNotification::class
        );

        Event::listen(
            ProductSynchronized::class,
            LogProductSynchronized::class
        );

        Event::listen(
            ProductWasNotSynchronized::class,
            LogProductWasNotSynchronized::class
        );
    }
}
