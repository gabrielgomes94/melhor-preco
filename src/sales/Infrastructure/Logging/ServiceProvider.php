<?php

namespace Src\Sales\Infrastructure\Logging;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Domain\Events\SaleOrderWasNotSynchronized;
use Src\Sales\Infrastructure\Logging\Listeners\LogException;
use Src\Sales\Infrastructure\Logging\Listeners\LogNotSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedSales;
use Src\Sales\Domain\Events\ItemSynchronized;
use Src\Sales\Domain\Events\ItemWasNotSynchronized;
use Src\Sales\Domain\Events\SaleSynchronized;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        Event::listen([
            SaleSynchronized::class,
        ], LogSynchronizedSales::class);

        Event::listen([
            ItemSynchronized::class,
        ], LogSynchronizedItem::class);

        Event::listen([
            ItemWasNotSynchronized::class,
        ], LogNotSynchronizedItem::class);

        Event::listen([
            SaleOrderWasNotSynchronized::class,
        ], LogException::class);
    }
}
