<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Users\Domain\Repositories\Repository as RepositoryInterface;
use Src\Users\Domain\Services\SynchronizeData as SynchronizeDataInterface;
use Src\Users\Infrastructure\Laravel\Repositories\Repository;
use Src\Users\Infrastructure\Laravel\Services\SynchronizeData;

class UsersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            RepositoryInterface::class,
            Repository::class
        );

        $this->app->bind(
            SynchronizeDataInterface::class,
            SynchronizeData::class
        );
    }
}
