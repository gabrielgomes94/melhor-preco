<?php

namespace Src\Notifications\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Notifications\Domain\Models\Notification;
use Src\Notifications\Domain\Models\NotificationObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Notification::observe(NotificationObserver::class);
    }
}
