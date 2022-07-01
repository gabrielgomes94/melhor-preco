<?php

namespace Tests\Integration\Marketplaces\Providers;

use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;
use Src\Marketplaces\Domain\Services\GetCategoriesWithCommissions as GetCategoriesWithCommissionsInterface;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Services\GetCategoriesWithCommissions;
use Tests\TestCase;

class MarketplacesServiceProviderTest extends TestCase
{
    public function test_should_bind_marketplace_repository(): void
    {
        // Act
        $result = $this->app->get(MarketplaceRepositoryInterface::class);


        // Assert
        $this->assertInstanceOf(MarketplaceRepository::class, $result);
    }

    public function test_should_bind_commissions_repository(): void
    {
        // Act
        $result = $this->app->get(CommissionRepositoryInterface::class);


        // Assert
        $this->assertInstanceOf(CommissionRepository::class, $result);
    }

    public function test_should_bind_get_categories_with_commissions_service(): void
    {
        // Act
        $result = $this->app->get(GetCategoriesWithCommissionsInterface::class);


        // Assert
        $this->assertInstanceOf(GetCategoriesWithCommissions::class, $result);
    }
}
