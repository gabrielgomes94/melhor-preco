<?php

namespace App\Services\Notifications;

use App\Repositories\Notifications\Options\Options;
use App\Repositories\Notifications\Repository;
use App\Services\Utils\Paginator;

class ListNotifications
{
    private Paginator $paginator;
    private Repository $repository;

    public function __construct(Paginator $paginator, Repository $repository)
    {
        $this->paginator = $paginator;
        $this->repository = $repository;
    }

    public function list(Options $options): array
    {
        $notificationsList = $this->repository->list($options);
        $main = $this->repository->get($options->main() ?? null);

        $paginator = $this->paginator->paginate(
            array: $notificationsList->get(),
            options: $options,
            count: $this->repository->count()
        );

        return [
            'notifications' => $notificationsList,
            'mainNotification' => $main,
            'paginator' => $paginator
        ];
    }

    public function markAsReaded(string $id, bool $value = true): string
    {
        return $this->repository->updateReadedStatus($id, $value);
    }

    public function markAsSolved(string $id, bool $value = true): string
    {
        return $this->repository->updateSolvedStatus($id, $value);
    }
}
