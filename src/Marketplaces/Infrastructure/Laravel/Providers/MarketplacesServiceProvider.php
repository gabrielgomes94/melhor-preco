<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetCommission;
use Src\Marketplaces\Infrastructure\Laravel\Services\UpdateCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;
use Src\Marketplaces\Domain\Services\GetCommission as GetCommissionInterface;
use Src\Marketplaces\Domain\Services\UpdateCommission as UpdateCommissionInterface;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;

class MarketplacesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bindRepositories();
        $this->bindUseCases();
    }

    private function bindRepositories()
    {
        $this->app->bind(MarketplaceRepositoryInterface::class, MarketplaceRepository::class);
    }

    private function bindUseCases()
    {
        $this->app->bind(GetCommissionInterface::class, GetCommission::class);
        $this->app->bind(UpdateCommissionInterface::class, UpdateCommission::class);
    }
}
