<?php

namespace App\View\Components\Notifications\Inbox\MessageList;

use App\Models\Notification;
use Illuminate\View\Component;

class Card extends Component
{
    private Notification $notification;

    public function __construct(Notification $notification)
    {
        dd('oioi');
        $this->notification = $notification;
    }


    public function render()
    {
        if ($this->notification->isReaded()) {
            return view('componentes.noitifications.inbox.message-list.readed-card', ['notification' => $this->notification]);
        }

        return view('componentes.noitifications.inbox.message-list.unreaded-card', ['notification' => $this->notification]);
    }

}
