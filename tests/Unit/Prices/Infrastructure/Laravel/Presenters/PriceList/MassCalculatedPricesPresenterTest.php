<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Prices\Domain\DataTransfer\ListPricesCalculated;
use Src\Prices\Domain\DataTransfer\PriceCalculatedFromProduct;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository;
use Tests\Data\Domain\Prices\CalculatedPriceData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MassCalculatedPricesPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_mass_calculated_prices(): void
    {
        // Arrange
        $presenter = new MassCalculatedPricesPresenter(
            new FilterPresenter(
                new CategoryRepository()
            ),
            new MarketplacesPresenter(
                new MarketplaceRepository()
            )
        );

        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $listPricesCalculated = new ListPricesCalculated(
            $marketplace,
            [
                new PriceCalculatedFromProduct(
                    ProductData::babyCarriage($user),
                    $marketplace,
                    CalculatedPriceData::babyCarriage()
                ),
                new PriceCalculatedFromProduct(
                    ProductData::babyChair($user),
                    $marketplace,
                    CalculatedPriceData::babyChair()
                ),
                new PriceCalculatedFromProduct(
                    ProductData::babyPacifier($user),
                    $marketplace,
                    CalculatedPriceData::babyPacifier(),
                ),
            ]
        );

        // Act
        $result = $presenter->present($listPricesCalculated, $user->getId());

        // Assert
        $expectedCurrentMarketplace = [
            'name' => 'Shopee',
            'slug' => 'shopee',
        ];
        $this->assertSame($expectedCurrentMarketplace, $result['currentMarketplace']);

        $expectedFilter = [
            'categories' => [],
            'minimumProfit' => null,
            'maximumProfit' => null,
            'sku' => null,
        ];
        $this->assertSame($expectedFilter, $result['filter']);

        $expectedMarketplaces = [
            [
                'slug' => 'shopee',
                'name' => 'Shopee',
            ],
        ];
        $this->assertSame($expectedMarketplaces, $result['marketplaces']);

        $expectedProducts = [
            [
                'sku' => '1234',
                'name' => 'Carrinho de Bebê',
                'price' => 'R$ 899,90',
                'profit' => 'R$ 135,13',
                'margin' => '15,02 %',
                'quantity' => 10.0,
                'variations' => [],
            ],
            [
                'sku' => '987',
                'name' => 'Cadeirinha para Carros',
                'price' => 'R$ 699,90',
                'profit' => 'R$ 150,17',
                'margin' => '21,46 %',
                'quantity' => 10.0,
                'variations' => [],
            ],
            [
                'sku' => '777',
                'name' => 'Chupeta',
                'price' => 'R$ 19,89',
                'profit' => 'R$ 9,25',
                'margin' => '46,51 %',
                'quantity' => 10.0,
                'variations' => [],
            ],
        ];
        $this->assertSame($expectedProducts, $result['products']);

        $this->assertContainsOnlyInstancesOf(Product::class, $result['paginator']->items());
    }
}
