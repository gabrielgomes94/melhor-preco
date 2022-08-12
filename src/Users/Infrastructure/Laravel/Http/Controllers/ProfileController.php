<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdatePassword;
use Src\Users\Infrastructure\Laravel\Http\Requests\UpdateProfile;
use Src\Users\Infrastructure\Laravel\Models\User;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;

class ProfileController extends Controller
{
    public function __construct(
        private Repository $repository
    ) {
    }

    public function show(): View
    {
        $user = $this->getUser();

        return view('pages.users.profile', [
            'name' => $user->getName(),
            'fiscalId' => $user->getFiscalId(),
            'phone' => str_replace('+55', '', $user->getPhone()),
        ]);
    }

    public function updateProfile(UpdateProfile $request): RedirectResponse
    {
        $this->repository->updateProfile(
            $this->getUser(),
            $request->validated()['name'],
            $request->validated()['phone'],
            $request->validated()['fiscal_id']
        );

        return redirect()->back();
    }

    public function updatePasword(UpdatePassword $request): RedirectResponse
    {
        if (
            !$this->repository->updatePassword(
                $this->getUser(),
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
