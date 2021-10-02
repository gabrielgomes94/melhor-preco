<?php

namespace App\View\Components\Notifications\Inbox\MessageList;

use App\Models\Notification;
use App\View\Components\Notifications\Notification\NotificationComponent;
use Barrigudinha\Notification\NullNotification;
use Illuminate\View\Component;

class Card extends Component
{
    private ?string $filter;
    protected ?Notification $notification;

    public function __construct(?Notification $notification, ?string $filter = '')
    {
        $this->notification = $notification;
        $this->filter = $filter;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
//        dd($this->filter);/**/
        if ($this->notification instanceof NullNotification) {
            return view('components.notifications.inbox.message-list.empty-list-card');
        }

        return view('components.notifications.inbox.message-list.card', [
            'notification' => $this->notification,
            'filter' => $this->filter,
        ]);
    }
}
