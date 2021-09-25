<?php

namespace App\Http\Controllers\Front\Notifications;

use App\Http\Controllers\Controller;
use App\Repositories\Notifications\Options\Options;
use App\Services\Notifications\ListNotifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    private ListNotifications $service;

    public function __construct(ListNotifications $service)
    {
        $this->service = $service;
    }

    public function list(Request $request)
    {
        $options = new Options(
            [
                'main' => $request->input('main'),
                'path' => '/inbox',
                'page' => $request->input('page') ?? 1,
            ]
        );

        if ($options->main()) {
            $this->service->markAsReaded($options->main(), false);
        }

        $data = $this->service->list($options);

        return view('pages.notifications.inbox', $data);
    }

    public function show(string $id)
    {
        return view('pages.notifications.inbox');
    }
}
