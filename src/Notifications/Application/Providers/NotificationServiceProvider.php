<?php

namespace Src\Notifications\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Notifications\Application\Services\CheckUnsolvedNotifications as CheckUnsolvedNotificationsImpl;
use Src\Notifications\Application\Services\ListNotifications as ListNotificationsImpl;
use Src\Notifications\Application\Services\UpdateStatus as UpdateStatusImpl;
use Src\Notifications\Domain\Contracts\Repository\Repository;
use Src\Notifications\Domain\Contracts\Services\CheckUnsolvedNotifications;
use Src\Notifications\Domain\Contracts\Services\ListNotifications;
use Src\Notifications\Domain\Contracts\Services\UpdateStatus;
use Src\Notifications\Infrastructure\Repositories\Repository as RepositoryImpl;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Repositories
         */
        $this->app->bind(Repository::class, RepositoryImpl::class);

        /*
         * Services
         */
        $this->app->bind(CheckUnsolvedNotifications::class, CheckUnsolvedNotificationsImpl::class);
        $this->app->bind(ListNotifications::class, ListNotificationsImpl::class);
        $this->app->bind(UpdateStatus::class, UpdateStatusImpl::class);

    }
}
