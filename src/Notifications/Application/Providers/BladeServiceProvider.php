<?php

namespace Src\Notifications\Application\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Src\Notifications\Presentation\Components\Inbox\MainMessage\Card as MainMessageCard;
use Src\Notifications\Presentation\Components\Inbox\MainMessage\Content;
use Src\Notifications\Presentation\Components\Inbox\MessageList\Card as MessageListCard;
use Src\Notifications\Presentation\Components\Notification\NotificationComponent;
use Src\Notifications\Presentation\Components\Notification\ReadedStatus;
use Src\Notifications\Presentation\Components\Notification\SolvedBadge;
use Src\Notifications\Presentation\Components\Notification\Timestamp;

class BladeServiceProvider extends ServiceProvider
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
        Blade::component('app.notifications.inbox.main-message.card', MainMessageCard::class);
        Blade::component('app.notifications.inbox.message-list.card', MessageListCard::class);
        Blade::component('app.notifications.notification.notification-component', NotificationComponent::class);
        Blade::component('app.notifications.notification.solved-badge', SolvedBadge::class);
        Blade::component('app.notifications.notification.readed-status', ReadedStatus::class);
        Blade::component('app.notifications.notification.timestamp', Timestamp::class);
        Blade::component('app.notifications.inbox.main-message.content', Content::class);
    }
}
