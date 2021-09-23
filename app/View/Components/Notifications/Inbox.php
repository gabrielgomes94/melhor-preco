<?php


namespace App\View\Components\Notifications;


use Barrigudinha\Notification\Notification;
use Barrigudinha\Notification\NotificationsList;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Inbox extends Component
{
    private NotificationsList $notifications;
    private Notification $mainNotification;
    private LengthAwarePaginator $paginator;

    public function __construct(NotificationsList $notifications, Notification $mainNotification)
    {
        $this->notifications = $notifications;
        $this->mainNotification = $mainNotification;
    }

    public function geNotificationstData(): array
    {
        $data = $this->notifications;

        $data = array_map(function(Notification $notification) {
            return array_merge($notification->toArray(), [
                'createdAt' => $notification->createdAt()->format('d/m/Y h:i')
            ]);
        }, $data->get());

        return $data;
    }

    public function render()
    {
        return view('components.notifications.inbox', [
            'notifications' => $this->geNotificationstData(),
            'mainNotification' => $this->mainNotification->toArray(),
        ]);
    }
}
