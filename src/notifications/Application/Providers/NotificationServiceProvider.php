<?php

namespace Src\Notifications\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Notifications\Presentation\Components\Inbox\MainMessage\Card as MainMessageCard;
use Src\Notifications\Presentation\Components\Inbox\MessageList\Card as MessageListCard;
use Src\Notifications\Presentation\Components\Notification\NotificationComponent;
use Src\Notifications\Presentation\Components\Notification\ReadedStatus;
use Src\Notifications\Presentation\Components\Notification\SolvedBadge;
use Src\Notifications\Presentation\Components\Notification\Timestamp;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('notifications.inbox.main-message.card', MainMessageCard::class);
        Blade::component('notifications.inbox.message-list.card', MessageListCard::class);
        Blade::component('notifications.notification.notification-component', NotificationComponent::class);
        Blade::component('notifications.notification.solved-badge', SolvedBadge::class);
        Blade::component('notifications.notification.readed-status', ReadedStatus::class);
        Blade::component('notifications.notification.timestamp', Timestamp::class);
    }
}
