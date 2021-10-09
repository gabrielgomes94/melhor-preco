<?php

namespace Src\Notifications\Domain\Models;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Notifications\Domain\Contracts\Models\NotificationsCollection as NotificationsCollectionInterface;

class NotificationsCollection implements NotificationsCollectionInterface
{
    private LengthAwarePaginator $paginator;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @inheritDoc
     */
    public function list(): array
    {
        return $this->paginator->items();
    }

    public function paginator()
    {
        return $this->paginator;
    }
}
