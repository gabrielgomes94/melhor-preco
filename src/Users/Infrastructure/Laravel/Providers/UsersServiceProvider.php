<?php

namespace Src\Users\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Users\Domain\Repositories\Repository;

class UsersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            Repository::class,
            \Src\Users\Infrastructure\Laravel\Repositories\Repository::class
        );
    }
}
