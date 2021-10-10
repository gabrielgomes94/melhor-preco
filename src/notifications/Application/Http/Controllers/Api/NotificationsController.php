<?php

namespace Src\Notifications\Application\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Src\Notifications\Domain\Contracts\Repository\Repository;
use Src\Notifications\Infrastructure\Repositories\Options\NoOptions;

class NotificationsController extends \App\Http\Controllers\Controller
{
    private Repository $repository;

    public function __construct(Repository $repository) {
        $this->repository = $repository;
    }

    public function count(): JsonResponse
    {
        $count = $this->repository->count(new NoOptions());

        return response()->json(compact('count'));
    }
}
