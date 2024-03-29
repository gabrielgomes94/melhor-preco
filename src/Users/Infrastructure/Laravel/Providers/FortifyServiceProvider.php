<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use Src\Users\Infrastructure\Laravel\Actions\CreateNewUser;
use Src\Users\Infrastructure\Laravel\Actions\ResetUserPassword;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Src\Users\Domain\UseCases\RegisterUser;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView(function () {
            return view('pages.users.auth.login');
        });

        $this->userRegistrationBindings();
        $this->resetPasswordBindings();
    }

    private function userRegistrationBindings(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function () {
            return view('pages.users.auth.register');
        });
    }

    private function resetPasswordBindings(): void
    {
        Fortify::requestPasswordResetLinkView(function () {
            return view('pages.users.auth.forgot-password');
        });
        Fortify::resetPasswordView(function ($request) {
            return view('pages.users.auth.reset-password', ['request' => $request]);
        });
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }
}
