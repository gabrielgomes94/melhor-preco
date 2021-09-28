<?php

namespace App\View\Components\Notifications\Inbox\MainMessage;

use App\View\Components\Notifications\Notification\NotificationComponent;
use Barrigudinha\Notification\NullNotification;

class Card extends NotificationComponent
{
    private const COMPONENT_PATH = 'components.notifications.inbox.main-message';

    public function render()
    {
        $path = self::COMPONENT_PATH;

        if ($this->notification instanceof NullNotification) {
            return view("{$path}.empty-card");
        }

        return view("{$path}.card", [
            'notification' => $this->notification,
        ]);
    }
}
