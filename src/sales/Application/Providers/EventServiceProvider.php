<?php

namespace Src\Sales\Application\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Sales\Application\Listeners\LogSynchronizedSales;
use Src\Sales\Domain\Events\CustomerSynchronized;
use Src\Sales\Domain\Events\InvoiceSynchronized;
use Src\Sales\Domain\Events\ItemSynchronized;
use Src\Sales\Domain\Events\PaymentSynchronized;
use Src\Sales\Domain\Events\SaleSynchronized;
use Src\Sales\Domain\Events\ShipmentSynchronized;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen([
            CustomerSynchronized::class,
            InvoiceSynchronized::class,
            ItemSynchronized::class,
            PaymentSynchronized::class,
            ShipmentSynchronized::class,
            SaleSynchronized::class,
        ], LogSynchronizedSales::class);
    }
}
