<?php

namespace Src\Notifications\Application\Services;

use Src\Notifications\Domain\Contracts\Repository\Options;
use Src\Notifications\Domain\Models\Notification;
use Src\Notifications\Application\Presenters\Inbox;
use App\Services\Utils\Paginator;
use Src\Notifications\Infrastructure\Repositories\Repository;

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
