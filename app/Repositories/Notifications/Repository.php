<?php

namespace App\Repositories\Notifications;

use App\Exceptions\Notification\NotificationNotFoundException;
use App\Factories\Notification\Notification as NotificationFactory;
use App\Models\Notification as NotificationModel;
use App\Repositories\Notifications\Options\Options;
use Barrigudinha\Notification\Notification;
use Barrigudinha\Notification\NotificationsList;
use Barrigudinha\Notification\Repositories\Contracts\Repository as NotificationRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class Repository implements NotificationRepository
{
    public function create(Notification $notification): bool
    {
        $notificationModel = new NotificationModel();
        $notificationModel->fill($notification->toArray());

        return $notificationModel->save();
    }

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

    public function list(Options $options): LengthAwarePaginator
    {
        if ($options->onlySolved()) {
            return $notifications = NotificationModel::whereNotNull('solved_at')
                ->orderBy('id')
                ->paginate(perPage: $options->perPage(), page: $options->page());
        }

        return $notifications = NotificationModel::whereNull('solved_at')
            ->orderBy('id')
            ->paginate(perPage: $options->perPage(), page: $options->page());
    }

    public function count(): int
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

    private function update(string $id, array $data): bool
    {
        $notificationModel = NotificationModel::find($id);

        if (!$notificationModel) {
            throw new NotificationNotFoundException('Notificação não encontrada');
        }

        $notificationModel->fill($data);

        return $notificationModel->save();
    }
}
