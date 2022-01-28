<?php

namespace Src\Marketplaces\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Marketplaces\Application\UseCase\CreateMarketplace as CreateStoreImpl;
use Src\Marketplaces\Domain\UseCase\Contracts\CreateMarketplace;

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
        $this->app->bind(CreateMarketplace::class, CreateStoreImpl::class);
    }
}
