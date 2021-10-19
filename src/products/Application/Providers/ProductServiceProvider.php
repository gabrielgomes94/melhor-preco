<?php

namespace Src\Products\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Products\Domain\Product\Contracts\Repositories\Repository;
use Src\Products\Infrastructure\Repositories\V2\Repository as RepositoryImpl;

class ProductServiceProvider extends ServiceProvider
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
        $this->app->bind(Repository::class, RepositoryImpl::class);
        //
    }
}
