<?php

namespace Barrigudinha\Notification\Repositories\Contracts;

use App\Repositories\Notifications\Options\Options;
use Barrigudinha\Notification\Notification;
use Barrigudinha\Notification\NotificationsList;

interface Repository
{
    public function create(Notification $notification): bool;

    public function get(?string $id): ?Notification;

    public function list(Options $options): NotificationsList;

    public function updateReadedStatus(string $id, bool $value): bool;

    public function updateSolvedStatus(string $id, bool $value): bool;
}
