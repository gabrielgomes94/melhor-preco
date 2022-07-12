<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Users\Domain\Repositories\Repository;
use Src\Users\Infrastructure\Laravel\UseCases\GetSynchronizationInfo as GetSynchronizationInfoImpl;
use Src\Users\Domain\UseCases\GetSynchronizationInfo;

class UsersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(GetSynchronizationInfo::class, GetSynchronizationInfoImpl::class);
        $this->app->bind(
            Repository::class,
            \Src\Users\Infrastructure\Laravel\Repositories\Repository::class
        );
    }
}
