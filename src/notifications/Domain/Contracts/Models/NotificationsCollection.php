<?php

namespace Src\Notifications\Domain\Contracts\Models;

interface NotificationsCollection
{
    /**
     * @return Notification[]
     */
    public function list(): array;

    public function paginator();
}
