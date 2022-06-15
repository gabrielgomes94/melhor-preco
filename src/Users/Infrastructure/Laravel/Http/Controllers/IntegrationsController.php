<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateErpRequest;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;

class IntegrationsController
{
    public function __construct(
        private Repository $repository
    ) {
    }

    public function list(): View
    {
        $user = auth()->user();

        return view('pages.users.integrations', [
            'erpToken' => $user->getErpToken(),
        ]);
    }

    public function updateErp(UpdateErpRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $this->repository->updateErp($user, $request->transform());

        return redirect()->back();
    }
}
