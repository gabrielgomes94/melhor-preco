<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use Src\Users\Infrastructure\Laravel\Actions\CreateNewUser;
use Src\Users\Infrastructure\Laravel\Actions\ResetUserPassword;
use Src\Users\Infrastructure\Laravel\Actions\UpdateUserPassword;
use Src\Users\Infrastructure\Laravel\Actions\UpdateUserProfileInformation;
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
        $this->create();
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }

    public function create(): void
    {
        Fortify::registerView(function () {
            return view('pages.auth.register');
        });

        Fortify::createUsersUsing(CreateNewUser::class);
    }
}
