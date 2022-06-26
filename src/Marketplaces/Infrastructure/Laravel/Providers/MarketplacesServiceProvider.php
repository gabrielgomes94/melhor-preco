<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetMarketplace;
use Src\Marketplaces\Infrastructure\Laravel\Services\SaveMarketplace;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetCommission;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetCommissionType;
use Src\Marketplaces\Infrastructure\Laravel\Services\ListMarketplaces;
use Src\Marketplaces\Infrastructure\Laravel\Services\UpdateCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\GetMarketplace as GetMarketplaceInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\SaveMarketplace as SaveMarketplaceInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission as GetCommissionInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommissionType as GetCommissionTypeInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces as ListMarketplacesInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\UpdateCommission as UpdateCommissionInterface;
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
        $this->app->bind(GetMarketplaceInterface::class, GetMarketplace::class);
        $this->app->bind(GetCommissionInterface::class, GetCommission::class);
        $this->app->bind(GetCommissionTypeInterface::class, GetCommissionType::class);
        $this->app->bind(ListMarketplacesInterface::class, ListMarketplaces::class);
        $this->app->bind(UpdateCommissionInterface::class, UpdateCommission::class);
        $this->app->bind(SaveMarketplaceInterface::class, SaveMarketplace::class);
    }
}
