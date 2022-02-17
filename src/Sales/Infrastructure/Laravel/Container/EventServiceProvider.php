<?php

namespace Src\Sales\Infrastructure\Laravel\Container;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Sales\Infrastructure\Logging\Listeners\LogNotSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedItem;
use Src\Sales\Infrastructure\Logging\Listeners\LogSynchronizedSales;
use Src\Sales\Domain\Events\CustomerSynchronized;
use Src\Sales\Domain\Events\InvoiceSynchronized;
use Src\Sales\Domain\Events\ItemSynchronized;
use Src\Sales\Domain\Events\ItemWasNotSynchronized;
use Src\Sales\Domain\Events\PaymentSynchronized;
use Src\Sales\Domain\Events\SaleSynchronized;
use Src\Sales\Domain\Events\ShipmentSynchronized;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {}
}
