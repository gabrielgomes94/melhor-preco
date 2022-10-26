<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplacesPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present(): void
    {
        // Arrange
        $user = UserData::persisted();
        MarketplaceData::magalu($user);
        MarketplaceData::shopee($user);
        MarketplaceData::olist($user);

        $presenter = new MarketplacesPresenter(
            new MarketplaceRepository()
        );

        // Act
        $result = $presenter->present($user->getId());

        // Assert
        $expected = [
            [
                'slug' => 'magalu',
                'name' => 'Magalu',
            ],
            [
                'slug' => 'olist',
                'name' => 'Olist',
            ],
            [
                'slug' => 'shopee',
                'name' => 'Shopee',
            ],
        ];
        $this->assertSame($expected, $result);
    }
}
