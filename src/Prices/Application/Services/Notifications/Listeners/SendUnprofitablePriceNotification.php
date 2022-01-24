<?php

namespace Src\Prices\Application\Services\Notifications\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Notifications\Domain\Notifications\Prices\UnprofitablePrice as UnprofitablePriceNotification;
use Src\Prices\Domain\Events\UnprofitablePrice;

class SendUnprofitablePriceNotification implements ShouldQueue
{
    public function handle(UnprofitablePrice $event): void
    {
        $user = User::first();

        $user->notify(new UnprofitablePriceNotification($event->toArray()));
    }
}
