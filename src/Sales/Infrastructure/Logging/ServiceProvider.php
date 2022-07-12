<?php

namespace Src\Sales\Infrastructure\Logging;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Src\Sales\Infrastructure\Laravel\Events\SaleOrderWasNotSynchronized;
use Src\Sales\Infrastructure\Logging\Listeners\LogException;
use Src\Sales\Infrastructure\Logging\Listeners\LogNotSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedSales;
use Src\Sales\Infrastructure\Laravel\Events\ItemSynchronized;
use Src\Sales\Infrastructure\Laravel\Events\ItemWasNotSynchronized;
use Src\Sales\Infrastructure\Laravel\Events\SaleSynchronized;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
//        Event::listen([
//            SaleSynchronized::class,
//        ], LogSynchronizedSales::class);
//
//        Event::listen([
//            ItemSynchronized::class,
//        ], LogSynchronizedItem::class);
//
//        Event::listen([
//            ItemWasNotSynchronized::class,
//        ], LogNotSynchronizedItem::class);
//
//        Event::listen([
//            SaleOrderWasNotSynchronized::class,
//        ], LogException::class);
    }
}
