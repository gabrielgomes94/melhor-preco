<?php

namespace Src\Notifications\Application\Presenters;

//use Barrigudinha\Notification\Notification;
use Src\Notifications\Domain\Models\Notification;
use Barrigudinha\Notification\NotificationsList;
use Barrigudinha\Notification\NullNotification;
use Illuminate\Pagination\LengthAwarePaginator;

class Inbox
{
    private ?Notification $mainNotification;
    private LengthAwarePaginator $notificationsList;

    public function __construct(
        LengthAwarePaginator $notificationsList,
        ?Notification $mainNotification
    ) {
        $this->notificationsList = $notificationsList;
        $this->mainNotification = $mainNotification;
    }

    public function isEmpty(): bool
    {
        return $this->notificationsList->count() === 0 && $this->mainNotification->attributes === null;
    }

    public function mainNotification(): ?Notification
    {
        return $this->mainNotification;
    }

    public function notifications(): array
    {
        return $this->notificationsList->items();
    }

    public function paginator(): LengthAwarePaginator
    {
        return $this->notificationsList;
    }
}
