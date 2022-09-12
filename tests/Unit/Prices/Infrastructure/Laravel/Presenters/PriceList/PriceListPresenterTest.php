<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\PriceList;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Marketplaces\Infrastructure\Laravel\Repositories\MarketplaceRepository;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Infrastructure\Laravel\Repositories\CategoryRepository;
use Src\Products\Infrastructure\Laravel\Repositories\Options\Options;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class PriceListPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_price_list(): void
    {
        // Arrange
        $user = UserData::make();
        $marketplace = MarketplaceData::shopee($user);
        $options = new Options(userId: $user->getId());

        ProductData::redBlanket($user, [
            PriceData::build($marketplace, ['value' => 79.9, 'profit' => 10.12])
        ]);
        ProductData::blueBlanket($user, [
            PriceData::build($marketplace, ['value' => 79.9, 'profit' => 10.12])
        ]);

        $paginator = new LengthAwarePaginator([
            ProductData::babyCarriage($user, [
                PriceData::build($marketplace, ['value' => 899.9, 'profit' => 120.0])
            ]),
            ProductData::babyChair($user, [
                PriceData::build($marketplace, ['value' => 699.9, 'profit' => 95.98])
            ]),
            ProductData::babyPacifier($user, [
                PriceData::build($marketplace, ['value' => 19.9, 'profit' => 6.5])
            ]),
            ProductData::blanket($user, [
                PriceData::build($marketplace, ['value' => 79.9, 'profit' => 10.12])
            ]),
        ], 10, 3);

        $presenter = new PriceListPresenter(
            new FilterPresenter(
                new CategoryRepository()
            ),
            new MarketplacesPresenter(
                new MarketplaceRepository()
            )
        );

        // Act
        $result = $presenter->list($paginator, $marketplace, $options, $user->getId());

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
                'profit' => 'R$ 120,00',
                'margin' => '13,33 %',
                'quantity' => 10.0,
                'variations' => [],
                'parentSku' => null,
            ],
            [
                'sku' => '987',
                'name' => 'Cadeirinha para Carros',
                'price' => 'R$ 699,90',
                'profit' => 'R$ 95,98',
                'margin' => '13,71 %',
                'quantity' => 10.0,
                'variations' => [],
                'parentSku' => null,
            ],
            [
                'sku' => '777',
                'name' => 'Chupeta',
                'price' => 'R$ 19,89',
                'profit' => 'R$ 6,50',
                'margin' => '32,66 %',
                'quantity' => 10.0,
                'variations' => [],
                'parentSku' => null,
            ],
            [
                'sku' => '821',
                'name' => 'Cobertor',
                'price' => 'R$ 79,90',
                'profit' => 'R$ 10,11',
                'margin' => '12,67 %',
                'quantity' => 10.0,
                'variations' => [
                    [
                        'sku' => '822',
                        'name' => 'Cobertor Vermelho',
                        'price' => 'R$ 79,90',
                        'profit' => 'R$ 10,11',
                        'margin' => '12,67 %',
                        'quantity' => 10.0,
                        'variations' => [],
                        'parentSku' => '821',
                    ],
                    [
                        'sku' => '823',
                        'name' => 'Cobertor Azul',
                        'price' => 'R$ 79,90',
                        'profit' => 'R$ 10,11',
                        'margin' => '12,67 %',
                        'quantity' => 10.0,
                        'variations' => [],
                        'parentSku' => '821',
                    ],
                ],
                'parentSku' => null,
            ]
        ];
        $this->assertSame($expectedProducts, $result['products']);

        $this->assertContainsOnlyInstancesOf(Product::class, $result['paginator']->items());
    }
}
