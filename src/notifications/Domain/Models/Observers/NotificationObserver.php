<?php

namespace Src\Notifications\Domain\Models\Observers;

use Src\Notifications\Domain\Models\Notification;

class NotificationObserver
{
    public function created(Notification $notification): void
    {
        if ($notification->type() === 'info') {
            $notification->markAsSolved();
        }
    }
}
