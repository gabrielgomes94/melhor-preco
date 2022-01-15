<?php

namespace Src\Notifications\Presentation\Components\Inbox\MainMessage;

use Src\Notifications\Domain\Notifications\Prices\UnprofitablePrice;
use Src\Notifications\Domain\Notifications\Products\ProductsSynchronized;
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

        if ($this->notification->type() === ProductsSynchronized::class) {
            return view('components.notifications.inbox.main-message.contents.products-synchronized', [
                'notification' => $this->notification,
            ]);
        }

        return view('components.notifications.inbox.main-message.content');
    }
}
