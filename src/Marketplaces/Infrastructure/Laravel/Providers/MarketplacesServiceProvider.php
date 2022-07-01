<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetCommission;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;
use Src\Marketplaces\Domain\Services\GetCommission as GetCommissionInterface;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;

class MarketplacesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Repositories
        $this->app->bind(MarketplaceRepositoryInterface::class, MarketplaceRepository::class);
        $this->app->bind(CommissionRepositoryInterface::class, CommissionRepository::class);

        // Services
        $this->app->bind(GetCommissionInterface::class, GetCommission::class);
    }
}
