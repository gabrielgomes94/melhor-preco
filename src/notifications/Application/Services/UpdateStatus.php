<?php

namespace Src\Notifications\Application\Services;

use Src\Notifications\Application\Exceptions\NotificationNotFoundException;
use Src\Notifications\Infrastructure\Repositories\Repository;
use Src\Notifications\Domain\Contracts\Services\UpdateStatus as UpdateStatusInterface;

class UpdateStatus implements UpdateStatusInterface
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function toggleReadingStatus(string $id): bool
    {
        $notification = $this->repository->get($id);

        if (!$notification) {
            throw new NotificationNotFoundException();
        }

        if ($notification->isRead()) {
            return $this->repository->updateReadedStatus($id, false);
        }

        return $this->repository->updateReadedStatus($id, true);
    }

    public function toggleSolvedStatus(string $id, bool $value = true): bool
    {
        $notification = $this->repository->get($id);

        if (!$notification) {
            throw new NotificationNotFoundException();
        }

        return $this->repository->updateSolvedStatus($id, $value);
    }
}
