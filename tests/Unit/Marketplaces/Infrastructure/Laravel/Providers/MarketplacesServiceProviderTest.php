<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Providers;

use Src\Marketplaces\Domain\Repositories\CommissionRepository as CommissionRepositoryInterface;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository as MarketplaceRepositoryInterface;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\CommissionRepository;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
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
}
