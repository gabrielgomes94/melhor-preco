<?php

namespace Src\Notifications\Presentation\Components\Inbox\MainMessage;

use Src\Notifications\Presentation\Components\Notification\NotificationComponent;

class Card extends NotificationComponent
{
    private const COMPONENT_PATH = 'components.notifications.inbox.main-message';

    public function render()
    {
        $path = self::COMPONENT_PATH;

        if (!$this->notification) {
            return view("{$path}.empty-card");
        }

        return view("{$path}.card", [
            'notification' => $this->notification,
        ]);
    }
}
