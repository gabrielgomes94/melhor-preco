<?php

namespace Src\Notifications\Domain\Contracts\Repository;

use ArrayAccess;
use Src\Notifications\Domain\Models\Notification;
use Src\Notifications\Domain\Models\NotificationsCollection;
use Src\Notifications\Infrastructure\Repositories\Options\Options;

interface Repository
{
    public function first(Options $options): ?Notification;

    public function get(string $id): ?Notification;

    public function list(Options $options): NotificationsCollection;

    public function count(Options $options): int;

    public function updateReadedStatus(string $id, bool $value): bool;

    public function updateSolvedStatus(string $id, bool $value): bool;
}
