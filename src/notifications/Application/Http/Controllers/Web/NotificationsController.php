<?php

namespace Src\Notifications\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Notifications\Domain\Contracts\Services\ListNotifications;
use Src\Notifications\Domain\Contracts\Services\UpdateStatus;
use Src\Notifications\Infrastructure\Repositories\Options\Options;

class NotificationsController extends Controller
{
    private ListNotifications $listNotificationsService;
    private UpdateStatus $updateStatusService;

    public function __construct(ListNotifications $listNotificationsService, UpdateStatus $updateStatusService) {
        $this->listNotificationsService = $listNotificationsService;
        $this->updateStatusService = $updateStatusService;
    }

    public function list(Request $request)
    {
        $options = new Options(
            [
                'main' => $request->input('main'),
                'path' => $request->fullUrlWithQuery($request->query()),
                'page' => $request->input('page') ?? 1,
                'filter' => $request->input('filter'),
            ]
        );

        if ($options->main()) {
            $this->updateStatusService->toggleReadingStatus($options->main());
        }

        $inbox = $this->listNotificationsService->list($options);

        return view('pages.notifications.inbox', [
            'inbox' => $inbox,
            'filter' => $options->filter(),
        ]);
    }

    public function updateReadedStatus(Request $request, string $id)
    {
        $this->updateStatusService->toggleReadingStatus($id);

        return redirect()->route('notifications.list');
    }

    public function updateSolvedStatus(Request $request, string $id)
    {
        $solvedStatus = $request->input('solved') === 'true';
        $this->updateStatusService->toggleSolvedStatus($id, $solvedStatus);

        return redirect()->route('notifications.list');
    }
}
