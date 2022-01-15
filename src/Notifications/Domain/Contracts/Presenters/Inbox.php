<?php

namespace Src\Notifications\Domain\Contracts\Presenters;

use Src\Notifications\Domain\Models\Notification;

interface Inbox
{
    public function isEmpty(): bool;

    public function mainNotification(): ?Notification;

    public function notifications(): array;

    /**
     * @return mixed
     */
    public function paginator();
}
