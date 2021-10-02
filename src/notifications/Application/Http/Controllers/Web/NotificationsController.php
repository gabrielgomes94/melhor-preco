<?php

namespace Src\Notifications\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Notifications\Application\Services\ListNotifications;
use Illuminate\Http\Request;
use Src\Notifications\Infraestructure\Repositories\Options;

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
                'path' => $request->fullUrl(),
                'page' => $request->input('page') ?? 1,
                'filter' => $request->input('filter'),
            ]
        );

        if ($options->main()) {
            $this->service->toggleReadingStatus($options->main());
        }

        $inbox = $this->service->list($options);

        return view('pages.notifications.inbox', [
            'inbox' => $inbox,
            'filter' => $options->filter(),
        ]);
    }

    public function updateReadedStatus(Request $request, string $id)
    {
        $this->service->toggleReadingStatus($id);

        return redirect()->route('notifications.list');
    }

    public function updateSolvedStatus(Request $request, string $id)
    {
        $solvedStatus = $request->input('solved') === 'true';
        $this->service->toggleSolvedStatus($id, $solvedStatus);

        return redirect()->route('notifications.list');
    }

    public function show(string $id)
    {
        return view('pages.notifications.inbox');
    }
}
