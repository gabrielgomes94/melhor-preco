<?php

namespace Src\Notifications\Domain\Models;

class NotificationObserver
{
    public function created(Notification $notification): void
    {
        if ($notification->category() === 'info') {
            $notification->markAsSolved();
        }
    }
}
