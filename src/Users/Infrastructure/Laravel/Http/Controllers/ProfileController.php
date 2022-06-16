<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateProfile;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;

class ProfileController
{
    public function __construct(
        private Repository $repository
    ) {
    }

    public function show(): View
    {
        $user = auth()->user();

        return view('pages.users.profile', [
            'name' => $user->getName(),
            'fiscalId' => $user->getFiscalId(),
            'phone' => str_replace('+55', '', $user->getPhone()),
        ]);
    }

    public function update(UpdateProfile $request): RedirectResponse
    {
        $user = auth()->user();
        $this->repository->updateProfile($user, $request->validated());

        return redirect()->back();
    }
}
