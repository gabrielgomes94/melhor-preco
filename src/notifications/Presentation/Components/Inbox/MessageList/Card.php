<?php

namespace Src\Notifications\Presentation\Components\Inbox\MessageList;

use Src\Notifications\Domain\Models\Notification;
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
        if (!$this->notification) {
            return view('components.notifications.inbox.message-list.empty-list-card');
        }

        return view('components.notifications.inbox.message-list.card', [
            'notification' => $this->notification,
            'filter' => $this->filter,
        ]);
    }
}
