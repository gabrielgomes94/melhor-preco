<?php

namespace Src\Sales\Application\Presenters\SalesList;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Application\Models\SaleOrder;
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
                'storeSaleOrderId' => '01',
                'selledAt' => '12/12/2021',
                'store' => 'Shopee',
                'value' => 'R$ 39,79',
                'products' => [
                    [
                        'formattedName' => '777 - Chupeta',
                        'sku' => '777',
                    ],
                    [
                        'formattedName' => '777 - Chupeta',
                        'sku' => '777',
                    ],
                ],
                'productsInTooltip' => '777 - Chupeta;777 - Chupeta',
                'quantity' => 2.0,
                'profit' => 'R$ 6,00',
                'status' => 'Registrada',
            ],
            [
                'saleOrderCode' => '101',
                'storeSaleOrderId' => '12',
                'selledAt' => '12/12/2021',
                'store' => 'Shopee',
                'value' => 'R$ 899,90',
                'products' => [
                    [
                        'formattedName' => '1234 - Carrinho de Bebê',
                        'sku' => '1234',
                    ],
                ],
                'productsInTooltip' => '1234 - Carrinho de Bebê',
                'quantity' => 1.0,
                'profit' => 'R$ 120,00',
                'status' => 'Registrada',
            ],
            [
                'saleOrderCode' => '102',
                'storeSaleOrderId' => '13',
                'selledAt' => '12/12/2021',
                'store' => 'Shopee',
                'value' => 'R$ 1.599,80',
                'products' => [
                    [
                        'formattedName' => '1234 - Carrinho de Bebê',
                        'sku' => '1234',
                    ],
                    [
                        'formattedName' => '987 - Cadeirinha para Carros',
                        'sku' => '987',
                    ],
                ],
                'productsInTooltip' => '1234 - Carrinho de Bebê;987 - Cadeirinha para Carros',
                'quantity' => 2.0,
                'profit' => 'R$ 200,00',
                'status' => 'Registrada',
            ],
            [
                'saleOrderCode' => '103',
                'storeSaleOrderId' => '14',
                'selledAt' => '12/12/2021',
                'store' => 'Shopee',
                'value' => 'R$ 612,15',
                'products' => [
                    [
                        'formattedName' => '589 - Berço',
                        'sku' => '589',
                    ],
                ],
                'productsInTooltip' => '589 - Berço',
                'quantity' => 1.0,
                'profit' => 'R$ 85,00',
                'status' => 'Registrada',
            ],
            [
                'saleOrderCode' => '104',
                'storeSaleOrderId' => '15',
                'selledAt' => '12/12/2021',
                'store' => 'Shopee',
                'value' => 'R$ 1.399,90',
                'products' => [
                    [
                        'formattedName' => '601 - Kit Berço e Carrinho',
                        'sku' => '601',
                    ],
                ],
                'productsInTooltip' => '601 - Kit Berço e Carrinho',
                'quantity' => 1.0,
                'profit' => 'R$ 145,00',
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
