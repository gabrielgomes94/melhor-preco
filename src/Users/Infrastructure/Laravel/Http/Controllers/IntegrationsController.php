<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateErpRequest;
use Src\Users\Infrastructure\Laravel\Presenters\SyncPresenter;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;

class IntegrationsController
{
    public function __construct(
        private Repository $repository,
        private SyncPresenter $presenter
    ) {
    }

    public function list(): View
    {
        $user = auth()->user();

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
        $user = auth()->user();
        $this->repository->updateErp($user, $request->transform());

        return redirect()->back();
    }
}
