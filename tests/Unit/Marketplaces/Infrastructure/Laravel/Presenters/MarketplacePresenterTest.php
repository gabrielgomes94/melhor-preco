<?php

namespace Tests\Unit\Marketplaces\Infrastructure\Laravel\Presenters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Presenters\MarketplacePresenter;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplacePresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_marketplace(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::magalu($user);
        $marketplace->uuid = '78d30a64-249f-498d-9f2b-915d94998ecc';
        $presenter = new MarketplacePresenter();
        $expected = [
            'commissionType' => 'categoryCommission',
            'commissions' => [
                1 => '10,20%',
                0 => '12,80%',
            ],
            'erpId' => '123456',
            'isActive' => true,
            'name' => 'Magalu',
            'status' => 'Ativo',
            'slug' => 'magalu',
            'uuid' => '78d30a64-249f-498d-9f2b-915d94998ecc',
            'freight' => [
                'defaultValue' => 0.0,
                'minimumFreightTableValue' => 0.0,
                'freightTable' => [],
            ],
        ];

        // Act
        $result = $presenter->present($marketplace);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_present_marketplace_list(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::magalu($user);
        $marketplace->uuid = '78d30a64-249f-498d-9f2b-915d94998ecc';
        $marketplace->user_id = '1';
        $presenter = new MarketplacePresenter();

        $expected = [
            'marketplaces' => [
                [
                    'commissionType' => 'categoryCommission',
                    'commissions' => [
                        1 => '10,20%',
                        0 => '12,80%',
                    ],
                    'erpId' => '123456',
                    'isActive' => true,
                    'name' => 'Magalu',
                    'status' => 'Ativo',
                    'slug' => 'magalu',
                    'uuid' => '78d30a64-249f-498d-9f2b-915d94998ecc',
                    'freight' => [
                        'defaultValue' => 0.0,
                        'minimumFreightTableValue' => 0.0,
                        'freightTable' => [],
                    ],
                ],
            ],
        ];
        $marketplaces = collect([$marketplace]);

        // Act
        $result = $presenter->presentList($marketplaces);

        // Assert
        $this->assertSame($expected, $result);
    }
}
