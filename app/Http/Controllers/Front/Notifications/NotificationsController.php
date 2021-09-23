<?php

namespace App\Http\Controllers\Front\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Paginator;
use App\Repositories\Notifications\Repository;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    private Paginator $paginator;
    private Repository $repository;

    public function __construct(Paginator $paginator, Repository $repository)
    {
        $this->paginator = $paginator;
        $this->repository = $repository;
    }

    public function list(Request $request)
    {
        $data = $this->repository->list();
        $main = $this->repository->get();
        $paginator = $this->paginator->paginate($data, $request, 5, 25);
//        dd($paginator);

        return view('pages.notifications.inbox', [
            'notifications' => $data,
            'mainNotification' => $main,
            'paginator' => $paginator
        ]);
    }

    public function show(string $id)
    {
        return view('pages.notifications.inbox');
    }
}
