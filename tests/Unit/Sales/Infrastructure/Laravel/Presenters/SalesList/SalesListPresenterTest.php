<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters\SalesList;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SalesListPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_a_sale_order_list(): void
    {
        // Arrange
        $presenter = app(SalesListPresenter::class);
        $user = UserData::persisted();
        $sales = $this->getSales($user);

        // Act
        $result = $presenter->listSaleOrder($sales, $user->getId());

        // Assert
        $expected = [
            [
                'saleOrderCode' => '100',
                'purchaseSaleOrderId' => '10',
                'storeSaleOrderId' => '12',
                'selledAt' => '12/12/2021',
                'store' => 'Shopee',
                'value' => 'R$ 1.450,00',
                'products' => [
                    [
                        'formattedName' => '1234 - Carrinho de Bebê',
                        'sku' => '1234',
                    ],
                    [
                        'formattedName' => '987 - Cadeirinha para Carros',
                        'sku' => '987',
                    ]
                ],
                'productsInTooltip' => '1234 - Carrinho de Bebê;987 - Cadeirinha para Carros',
                'productsValue' => 1.0,
                'profit' => 'R$ 250,00',
                'status' => 'Registrada',
            ],
            [
                'saleOrderCode' => '101',
                'purchaseSaleOrderId' => '11',
                'storeSaleOrderId' => '12',
                'selledAt' => '12/12/2021',
                'store' => 'Shopee',
                'value' => 'R$ 100,00',
                'products' => [
                    [
                        'formattedName' => '777 - Chupeta',
                        'sku' => '777',
                    ],
                    [
                        'formattedName' => '777 - Chupeta',
                        'sku' => '777',
                    ],
                    [
                        'formattedName' => '777 - Chupeta',
                        'sku' => '777',
                    ],
                    [
                        'formattedName' => '777 - Chupeta',
                        'sku' => '777',
                    ],
                    [
                        'formattedName' => '777 - Chupeta',
                        'sku' => '777',
                    ],
                ],
                'productsInTooltip' => '777 - Chupeta;777 - Chupeta;777 - Chupeta;777 - Chupeta;777 - Chupeta',
                'productsValue' => 1.0,
                'profit' => 'R$ 20,00',
                'status' => 'Registrada',
            ],
            [
                'saleOrderCode' => '101',
                'purchaseSaleOrderId' => '11',
                'storeSaleOrderId' => '12',
                'selledAt' => '12/12/2021',
                'store' => 'Olist',
                'value' => 'R$ 899,00',
                'products' => [
                    [
                        'formattedName' => '1234 - Carrinho de Bebê',
                        'sku' => '1234',
                    ],
                ],
                'productsInTooltip' => '1234 - Carrinho de Bebê',
                'productsValue' => 1.0,
                'profit' => 'R$ 120,00',
                'status' => 'Registrada',
            ],
        ];
        $this->assertSame($expected, $result);
    }

    public function getSales(User $user): SaleOrdersCollection
    {
        SalesDatabase::setup($user);

        $sales = new SaleOrdersCollection(
            SaleOrder::where('user_id', $user->getId())->get()->all()
        );
        return $sales;
    }
}
