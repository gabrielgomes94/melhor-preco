<?php

namespace Src\Notifications\Domain\Contracts\Services;

use Src\Notifications\Application\Presenters\Inbox;
use Src\Notifications\Domain\Contracts\Repository\Options;

interface ListNotifications
{
    public function list(Options $options): Inbox;
}
