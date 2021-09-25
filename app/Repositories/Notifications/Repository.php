<?php

namespace App\Repositories\Notifications;

use App\Exceptions\Notification\NotificationNotFoundException;
use App\Factories\Notification\Notification as NotificationFactory;
use App\Models\Notification as NotificationModel;
use App\Repositories\Notifications\Options\Options;
use Barrigudinha\Notification\Notification;
use Barrigudinha\Notification\NotificationsList;
use Barrigudinha\Notification\Repositories\Contracts\Repository as NotificationRepository;

class Repository implements NotificationRepository
{
    public function create(Notification $notification): bool
    {
        $notificationModel = new NotificationModel();
        $notificationModel->fill($notification->toArray());

        return $notificationModel->save();
    }

    public function get(?string $id = null): ?Notification
    {
        if (!$id) {
            $notification = NotificationModel::where('is_solved', false)->first();

            return NotificationFactory::buildFromModel($notification);
        }

        $notification = NotificationModel::find($id);

        return NotificationFactory::buildFromModel($notification);
    }

    public function list(Options $options): NotificationsList
    {
        $notifications = NotificationModel::where('is_solved', false)
            ->orderBy('id')
            ->paginate(perPage: $options->perPage(), page: $options->page())
            ->items();

        foreach ($notifications as $notificationModel) {
            $notificationsList[] = NotificationFactory::buildFromModel($notificationModel);
        }

        return new NotificationsList($notificationsList ?? []);
    }

    public function count(): int
    {
        return NotificationModel::where('is_solved', false)->count();
    }

    public function updateReadedStatus(string $id, bool $value): bool
    {
        return $this->update($id, ['is_readed' => $value]);
    }

    public function updateSolvedStatus(string $id, bool $value): bool
    {
        return $this->update($id, ['is_solved' => $value]);
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
