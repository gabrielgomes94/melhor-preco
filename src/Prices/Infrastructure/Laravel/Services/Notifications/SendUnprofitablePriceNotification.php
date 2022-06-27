<?php

namespace Src\Prices\Infrastructure\Laravel\Services\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Prices\Domain\Events\UnprofitablePrice;
use Src\Users\Infrastructure\Laravel\Models\User;

class SendUnprofitablePriceNotification implements ShouldQueue
{
    public function handle(UnprofitablePrice $event): void
    {
        $user = User::first();

//        $user->notify(new UnprofitablePriceNotification($event->toArray()));
    }
}
