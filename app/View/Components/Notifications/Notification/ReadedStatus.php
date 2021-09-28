<?php

namespace App\View\Components\Notifications\Notification;

class ReadedStatus extends NotificationComponent
{
    private const COMPONENT_PATH = 'components.notifications.notification.readed-status';

    public function render()
    {
        $path = self::COMPONENT_PATH;

        if ($this->notification->isRead()) {
            return view( "{$path}.readed", [
                'notification' => $this->notification->toArray(),
            ]);
        }

        return view("{$path}.unreaded", [
            'notification' => $this->notification->toArray(),
        ]);
    }
}
