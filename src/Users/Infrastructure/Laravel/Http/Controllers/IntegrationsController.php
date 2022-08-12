<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateErpRequest;
use Src\Users\Infrastructure\Laravel\Presenters\SyncPresenter;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;

class IntegrationsController extends Controller
{
    public function __construct(
        private Repository $repository,
        private SyncPresenter $presenter
    ) {
    }

    public function list(): View
    {
        $user = $this->getUser();

        return view(
            'pages.users.integrations',
            array_merge(
                ['erpToken' => $user->getErpToken()],
                $this->presenter->present($user->getAuthIdentifier())
            )
        );
    }

    public function updateErp(UpdateErpRequest $request): RedirectResponse
    {
        $this->repository->updateErp($this->getUser(), $request->transform());

        return redirect()->back();
    }
}
