<?php

namespace Src\Notifications\Infraestructure\Repositories;

use App\Exceptions\Notification\NotificationNotFoundException;
use Src\Notifications\Domain\Models\Notification as NotificationModel;
use Src\Notifications\Domain\Contracts\Repository\Repository as NotificationRepository;
use Illuminate\Pagination\LengthAwarePaginator;

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
