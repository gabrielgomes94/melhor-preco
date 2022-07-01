<?php

namespace Tests\Integration\Marketplaces\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Exceptions\MarketplaceSlugAlreadyExists;
use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace as MarketplaceModel;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Marketplaces\MarketplaceSettingsData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplaceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_create_marketplace(): void
    {
        // Arrange
        UserData::make(['id' => 1]);
        $data = MarketplaceSettingsData::make();

        $repository = $this->app->get(MarketplaceRepository::class);

        // Act
        $result = $repository->create($data);

        // Assert
        $this->assertInstanceOf(Marketplace::class, $result);
        $this->assertCount(1, MarketplaceModel::withUser(1)->get());
    }

    public function test_should_not_create_marketplace_when_slug_already_exists(): void
    {
        // Arrange
        $user = UserData::make(['id' => 1]);
        MarketplaceData::persisted(
            $user,
            ['slug' => 'magalu']
        );
        $data = MarketplaceSettingsData::make(['slug' => 'magalu']);

        $repository = $this->app->get(MarketplaceRepository::class);

        // Expects
        $this->expectException(MarketplaceSlugAlreadyExists::class);

        // Act
        $repository->create($data);
    }

    public function test_should_get_marketplace_by_erp_id(): void
    {
        // Arrange
        MarketplaceData::persisted(
            UserData::make(['id' => 1]),
            ['erp_id' => '12345678']
        );
        $repository = $this->app->get(MarketplaceRepository::class);

        // Act
        $result = $repository->getByErpId('12345678', 1);

        // Assert
        $this->assertInstanceOf(Marketplace::class, $result);
    }

    public function test_should_not_get_marketplace_by_erp_id(): void
    {
        // Arrange
        $repository = $this->app->get(MarketplaceRepository::class);

        // Act
        $result = $repository->getByErpId('12345678', 1);

        // Assert
        $this->assertNull($result);
    }

    public function test_should_get_marketplace_by_slug(): void
    {
        // Arrange
        MarketplaceData::persisted(
            UserData::make(['id' => 1]),
            ['slug' => 'shopee']
        );
        $repository = $this->app->get(MarketplaceRepository::class);

        // Act
        $result = $repository->getBySlug('shopee', 1);

        // Assert
        $this->assertInstanceOf(Marketplace::class, $result);
    }

    public function test_should_get_marketplace_by_uuid(): void
    {
        // Arrange
        $repository = $this->app->get(MarketplaceRepository::class);

        // Act
        $result = $repository->getBySlug('shopee', 1);

        // Assert
        $this->assertNull($result);
    }

    public function test_should_list_marketplaces(): void
    {
        // Arrange
        $user = UserData::make(['id' => 1]);
        MarketplaceData::persisted($user);
        MarketplaceData::persisted(
            $user,
            ['slug' => 'shopee']
        );
        MarketplaceData::persisted(
            $user,
            ['slug' => 'mercado-livre']
        );
        $repository = $this->app->get(MarketplaceRepository::class);

        // Act
        $result = $repository->list(1);

        // Assert
        $this->assertContainsOnlyInstancesOf(Marketplace::class, $result);
        $this->assertSame(3, count($result));
    }

    public function test_should_update_marketplace(): void
    {
        // Arrange
        $user = UserData::make(['id' => 1]);
        $marketplace = MarketplaceData::persisted(
            $user,
            [
                'name' => 'Shopee',
                'slug' => 'shopee',
                'is_active' => true,
                'uuid' => 'ac996a0e-ae2f-47b3-aaee-e9e396294395',
            ]
        );
        $data = MarketplaceSettingsData::make([
            'isActive' => false,
        ]);

        $repository = $this->app->get(MarketplaceRepository::class);

        // Act
        $result = $repository->update($marketplace, $data);

        // Assert
        $this->assertTrue($result);

        $marketplace = MarketplaceModel::where('uuid', 'ac996a0e-ae2f-47b3-aaee-e9e396294395')->first();
        $this->assertFalse($marketplace->isActive());
    }

    public function test_should_not_update_marketplace_when_slugs_already_exists(): void
    {
        // Arrange
        $user = UserData::make(['id' => 1]);
        $marketplaceToUpdate = MarketplaceData::persisted(
            $user,
            ['name' => 'Shopee', 'slug' => 'shopee']
        );
        MarketplaceData::persisted(
            $user,
            ['name' => 'Magalu', 'slug' => 'magalu']
        );
        $data = MarketplaceSettingsData::make(['slug' => 'magalu']);
        $repository = $this->app->get(MarketplaceRepository::class);

        // Expects
        $this->expectException(MarketplaceSlugAlreadyExists::class);

        // Act
        $repository->update($marketplaceToUpdate, $data);
    }
}
