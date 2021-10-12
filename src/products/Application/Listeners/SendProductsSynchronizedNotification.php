<?php

namespace Src\Products\Application\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Src\Notifications\Domain\Notifications\Products\ProductsSynchronized as ProductsSynchronizedNotification;
use Src\Products\Domain\Events\ProductsSynchronized;

class SendProductsSynchronizedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductsSynchronized  $event
     * @return void
     */
    public function handle(ProductsSynchronized $event)
    {
        if (!$user = User::find($event->userId())) {
            return;
        }

        $user->notify(new ProductsSynchronizedNotification($event->createdCount(), $event->updatedCount()));
    }
}
