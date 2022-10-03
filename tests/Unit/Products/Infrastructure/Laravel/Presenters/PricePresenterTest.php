<?php

namespace Src\Products\Infrastructure\Laravel\Presenters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class PricePresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_prices(): void
    {
        // Arrange
        $user = UserData::persisted();
        $this->actingAs($user);

        $product = ProductData::babyCarriage($user, [
            PriceData::build(MarketplaceData::magalu($user), ['value' => 889.90, 'profit' => 120.0]),
            PriceData::build(MarketplaceData::shopee($user), ['value' => 889.90, 'profit' => 135.0]),
        ]);

        $presenter = new PricePresenter();

        $expected = [
            [
                'value' => 'R$ 889,90',
                'profit' => 'R$ 120,00',
                'marketplaceName' => 'Magalu',
                'marketplaceSlug' => 'magalu',
                'margin' => '13,48 %',
                'productSku' => '1234',
            ],
            [
                'value' => 'R$ 889,90',
                'profit' => 'R$ 135,00',
                'marketplaceName' => 'Shopee',
                'marketplaceSlug' => 'shopee',
                'margin' => '15,17 %',
                'productSku' => '1234',
            ],
        ];

        // Act
        $result = $presenter->present($product);

        // Assert
        $this->assertSame($expected, $result);
    }
}
