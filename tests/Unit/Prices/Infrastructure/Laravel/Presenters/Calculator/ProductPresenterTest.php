<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present(): void
    {
        // Arrange
        $presenter = new ProductPresenter();

        $user = UserData::make();
        $marketplace = MarketplaceData::magalu($user);
        $product = ProductData::babyCarriage($user, [
            PriceData::build($marketplace, ['value' => 949.9])
        ]);

        // Act
        $result = $presenter->present($marketplace, $product);

        // Assert
        $expected = [
            'id' => '1234',
            'header' => '1234 - Carrinho de Bebê',
            'currentPrice' => 'R$ 949,90',
        ];
        $this->assertSame($expected, $result);
    }
}
