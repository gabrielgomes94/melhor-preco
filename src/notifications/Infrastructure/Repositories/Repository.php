<?php

namespace Src\Notifications\Infrastructure\Repositories;

use Src\Notifications\Domain\Contracts\Repository\Options;
use Src\Notifications\Domain\Models\Notification as NotificationModel;
use Src\Notifications\Domain\Contracts\Repository\Repository as NotificationRepository;
use Src\Notifications\Domain\Models\NotificationsCollection;

class Repository implements NotificationRepository
{
    public function first(Options $options): ?NotificationModel
    {
        if ($options->onlySolved()) {
            return NotificationModel::whereNotNull('solved_at')
                ->orderBy('id')
                ->first();
        }

        return NotificationModel::whereNull('solved_at')
            ->orderBy('id')
            ->first();
    }

    public function get(string $id): ?NotificationModel
    {
        if (!$notification = NotificationModel::find($id)) {
            return null;
        }

        return $notification;
    }

    public function list(Options $options): NotificationsCollection
    {
        if ($options->onlySolved()) {
            $notifications = NotificationModel::whereNotNull('solved_at')
                ->orderBy('created_at')
                ->paginate(perPage: $options->perPage(), page: $options->page());

            return new NotificationsCollection($notifications);
        }

        $notifications = NotificationModel::whereNull('solved_at')
            ->orderBy('created_at')
            ->paginate(perPage: $options->perPage(), page: $options->page());

        return new NotificationsCollection($notifications);
    }

    public function count(Options $options): int
    {
        return NotificationModel::where('solved_at', null)->count();
    }

    public function updateReadedStatus(string $id, bool $value): bool
    {
        $notificationModel = NotificationModel::find($id);

        $value
            ? $notificationModel->markAsRead()
            : $notificationModel->markAsUnread();

        return true;
    }

    public function updateSolvedStatus(string $id, bool $value): bool
    {
        $notificationModel = NotificationModel::find($id);

        $value
            ? $notificationModel->markAsSolved()
            : $notificationModel->markAsUnsolved();

        return true;
    }
}
