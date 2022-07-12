<?php

namespace Src\Sales\Infrastructure\Laravel\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Sales\Infrastructure\Logging\Listeners\LogNotSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedSales;
use Src\Sales\Infrastructure\Laravel\Events\CustomerSynchronized;
use Src\Sales\Infrastructure\Laravel\Events\InvoiceSynchronized;
use Src\Sales\Infrastructure\Laravel\Events\ItemSynchronized;
use Src\Sales\Infrastructure\Laravel\Events\ItemWasNotSynchronized;
use Src\Sales\Infrastructure\Laravel\Events\SaleSynchronized;
use Src\Sales\Infrastructure\Laravel\Events\ShipmentSynchronized;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {}
}
