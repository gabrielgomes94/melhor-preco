<?php

namespace Src\Notifications\Presentation\Components\Inbox\MainMessage;

use Src\Notifications\Domain\Notifications\Prices\UnprofitablePrice;
use Src\Notifications\Presentation\Components\Notification\NotificationComponent;

class Content extends NotificationComponent
{
    public function render()
    {
        if ($this->notification->type() === UnprofitablePrice::class) {
            return view('components.notifications.inbox.main-message.contents.unprofitable-price', [
                'notification' => $this->notification,
            ]);
        }

        return view('components.notifications.inbox.main-message.content');
    }
}
