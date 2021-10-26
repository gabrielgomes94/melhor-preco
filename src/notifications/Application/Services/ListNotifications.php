<?php

namespace Src\Notifications\Application\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Notifications\Domain\Contracts\Repository\Options;
use Src\Notifications\Domain\Contracts\Services\ListNotifications as ListNotificationsInterface;
use Src\Notifications\Domain\Models\Notification;
use Src\Notifications\Application\Presenters\Inbox;
use Src\Notifications\Infrastructure\Repositories\Repository;

class ListNotifications implements ListNotificationsInterface
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function list(Options $options): Inbox
    {
        $notificationsList = $this->repository->list($options);
        $main = $this->getMainNotification($options);

        $paginator = new LengthAwarePaginator(
            $notificationsList->list(),
            $this->repository->count($options),
            $options->perPage(),
            $options->page(),
            [
                'path' => $options->url(),
                'query' => $options->query(),
            ]
        );

        return new Inbox($paginator, $main);
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
}
