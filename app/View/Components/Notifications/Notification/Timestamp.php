<?php

namespace App\View\Components\Notifications\Notification;

class Timestamp extends NotificationComponent
{
    private const COMPONENT_PATH = 'components.notifications.notification.timestamp';

    public ?string $createdAt;

    public function render()
    {
        $this->createdAt = $this->getCreatedAt();

        return view(self::COMPONENT_PATH);
    }

    private function getCreatedAt(): ?string
    {
        return $this->notification->createdAt()?->format('d/m/Y h:i');
    }
}
