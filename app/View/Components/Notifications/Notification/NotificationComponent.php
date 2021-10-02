<?php

namespace App\View\Components\Notifications\Notification;

use App\Models\Notification;
use Illuminate\View\Component;

abstract class NotificationComponent extends Component
{
    protected ?Notification $notification;

    public function __construct(?Notification $notification)
    {
        $this->notification = $notification;
    }

    abstract public function render();
}
