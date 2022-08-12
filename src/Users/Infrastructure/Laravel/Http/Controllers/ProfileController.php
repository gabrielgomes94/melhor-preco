<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdatePassword;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateProfile;
use Src\Users\Infrastructure\Laravel\Models\User;
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

    public function updateProfile(UpdateProfile $request): RedirectResponse
    {
        $user = auth()->user();

        $this->repository->updateProfile(
            $user,
            $request->validated()['name'],
            $request->validated()['phone'],
            $request->validated()['fiscal_id']
        );

        return redirect()->back();
    }

    public function updatePasword(UpdatePassword $request): RedirectResponse
    {
        $user = auth()->user();
        if (
            !$this->repository->updatePassword(
                $user,
                $request->validated()['current_password'],
                $request->validated()['password']
            )
        ) {
            session()->flash('error', 'Senha não foi atualizada.');
            return redirect()->back();
        }

        session()->flash('message', 'Senha foi atualizada com sucesso.');
        return redirect()->back();
    }
}
