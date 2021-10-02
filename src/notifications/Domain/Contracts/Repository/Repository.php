<?php

namespace Src\Notifications\Domain\Contracts\Repository;

use Src\Notifications\Domain\Models\Notification as NotificationModel;
use Barrigudinha\Notification\Notification;

interface Repository
{
//    public function create(Notification $notification): bool;

    public function get(string $id): ?NotificationModel;

//    public function list(Options $options): NotificationsList;

    public function updateReadedStatus(string $id, bool $value): bool;

    public function updateSolvedStatus(string $id, bool $value): bool;
}
