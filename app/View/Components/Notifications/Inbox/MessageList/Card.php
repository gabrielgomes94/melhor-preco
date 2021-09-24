<?php

namespace App\View\Components\Notifications\Inbox\MessageList;

use App\View\Components\Notifications\Notification\NotificationComponent;

class Card extends NotificationComponent
{
    /**
     * @inheritDoc
     */
    public function render()
    {
        $data = array_merge($this->notification->toArray(), [
            'createdAt' => $this->notification->createdAt()->format('d/m/Y h:i')
        ]);

        return view('components.notifications.inbox.message-list.card', [
            'data' => $data,
            'notification' => $this->notification,
        ]);
    }
}
