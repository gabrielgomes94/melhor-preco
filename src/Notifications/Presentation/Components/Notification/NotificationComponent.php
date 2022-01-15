<?php

namespace Src\Notifications\Presentation\Components\Notification;

use Illuminate\View\Component;
use Src\Notifications\Domain\Models\Notification;

abstract class NotificationComponent extends Component
{
    protected ?Notification $notification;

    public function __construct(?Notification $notification)
    {
        $this->notification = $notification;
    }

    abstract public function render();
}
