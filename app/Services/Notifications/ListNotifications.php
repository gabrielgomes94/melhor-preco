<?php

namespace App\Services\Notifications;

use App\Models\Notification;
use App\Repositories\Notifications\Options\Options;
use App\Repositories\Notifications\Repository;
use App\Services\Notifications\Transformers\Inbox;
use App\Services\Utils\Paginator;
use Barrigudinha\Notification\NullNotification;

class ListNotifications
{
    private Paginator $paginator;
    private Repository $repository;

    public function __construct(Paginator $paginator, Repository $repository)
    {
        $this->paginator = $paginator;
        $this->repository = $repository;
    }

    private function getMainNotification(Options $options): ?Notification
    {
        if ($options->main()) {
            return $this->repository->get($options->main());
        }

        if ($firstNotification = $this->repository->first($options)) {
            return $firstNotification;
        }

        return null;
    }

    public function list(Options $options): Inbox
    {
        $notificationsList = $this->repository->list($options);
        $main = $this->getMainNotification($options);

        return new Inbox($notificationsList, $main);
    }

    public function toggleReadingStatus(string $id): string
    {
        $notification = $this->repository->get($id);

        if (!$notification) {
            throw new \Exception();
        }

        if ($notification->isRead()) {

            return $this->repository->updateReadedStatus($id, false);
        }

        return $this->repository->updateReadedStatus($id, true);
    }

    public function toggleSolvedStatus(string $id, bool $value = true): string
    {
        return $this->repository->updateSolvedStatus($id, $value);
    }
}
