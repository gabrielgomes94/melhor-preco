<?php

namespace Src\Marketplaces\Infrastructure\Laravel\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Src\Marketplaces\Application\UseCases\CreateMarketplace;
use Src\Marketplaces\Application\UseCases\GetCommission;
use Src\Marketplaces\Application\UseCases\GetCommissionType;
use Src\Marketplaces\Application\UseCases\ListMarketplaces;
use Src\Marketplaces\Application\UseCases\UpdateCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\CreateMarketplace as CreateMarketplaceInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommission as GetCommissionInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\GetCommissionType as GetCommissionTypeInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\ListMarketplaces as ListMarketplacesInterface;
use Src\Marketplaces\Domain\UseCases\Contracts\UpdateCommission as UpdateCommissionInterface;
use Src\Marketplaces\Infrastructure\Laravel\Eloquent\MarketplaceRepository;

class MarketplacesServiceProvider extends ServiceProvider
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
        $this->bindRepositories();
        $this->bindUseCases();
    }

    private function bindRepositories()
    {
        $this->app->bind(MarketplaceRepositoryInterface::class, MarketplaceRepository::class);
    }

    private function bindUseCases()
    {
        $this->app->bind(CreateMarketplaceInterface::class, CreateMarketplace::class);
        $this->app->bind(GetCommissionInterface::class, GetCommission::class);
        $this->app->bind(GetCommissionTypeInterface::class, GetCommissionType::class);
        $this->app->bind(ListMarketplacesInterface::class, ListMarketplaces::class);
        $this->app->bind(UpdateCommissionInterface::class, UpdateCommission::class);
    }
}
