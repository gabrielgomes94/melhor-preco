<?php

namespace Src\Stores\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Stores\Application\UseCase\CreateStore as CreateStoreImpl;
use Src\Stores\Domain\UseCase\Contracts\CreateStore;

class StoresServiceProvider extends ServiceProvider
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
        // Use Cases
        $this->app->bind(CreateStore::class, CreateStoreImpl::class);
    }
}
