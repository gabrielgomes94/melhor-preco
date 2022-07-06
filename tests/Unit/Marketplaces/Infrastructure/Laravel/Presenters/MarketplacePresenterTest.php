<?php

namespace Tests\Unit\Marketplaces\Infrastructure\Laravel\Presenters;

use Src\Marketplaces\Infrastructure\Laravel\Presenters\MarketplacePresenter;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\TestCase;

class MarketplacePresenterTest extends TestCase
{
    public function test_should_present_marketplace(): void
    {
        // Arrange
        $marketplace = MarketplaceData::make();
        $marketplace->uuid = '78d30a64-249f-498d-9f2b-915d94998ecc';
        $marketplace->user_id = '1';
        $presenter = new MarketplacePresenter();
        $expected = [
            'commissionType' => 'uniqueCommission',
            'commissions' => [
                '12,80%'
            ],
            'erpId' => '123456',
            'isActive' => true,
            'name' => 'Magalu',
            'status' => 'Ativo',
            'slug' => 'magalu',
            'uuid' => '78d30a64-249f-498d-9f2b-915d94998ecc',
        ];

        // Act
        $result = $presenter->present($marketplace);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_should_present_marketplace_list(): void
    {
        // Arrange
        $marketplace = MarketplaceData::make();
        $marketplace->uuid = '78d30a64-249f-498d-9f2b-915d94998ecc';
        $marketplace->user_id = '1';
        $presenter = new MarketplacePresenter();

        $expected = [
            'marketplaces' => [
                [
                    'commissionType' => 'uniqueCommission',
                    'commissions' => [
                        '12,80%'
                    ],
                    'erpId' => '123456',
                    'isActive' => true,
                    'name' => 'Magalu',
                    'status' => 'Ativo',
                    'slug' => 'magalu',
                    'uuid' => '78d30a64-249f-498d-9f2b-915d94998ecc',
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
