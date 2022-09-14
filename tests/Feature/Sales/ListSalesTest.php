<?php

namespace Tests\Feature\Sales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class ListSalesTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_list_sales(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_some_sales();

        $this->when_i_want_to_see_those_sales();

        $this->then_i_must_see_the_sales_list_page();
    }

    public function test_should_list_sales_filtering_by_date(): void
    {}

    private function given_i_have_some_sales(): void
    {
        $productBabyCarriage = ProductData::babyCarriage($this->user);
        $productBabyChair = ProductData::babyChair($this->user);
        $productBabyPacifier = ProductData::babyPacifier($this->user);

        SaleOrderData::persisted(
            $this->user,
            [
                'sale_order_id' => '100',
                'purchase_order_id' => '10',
                'store_id' => '1234567',
                'total_profit' => 250.0,
                'total_value' => 1450.0,
            ],
            [
                SaleItemData::make($productBabyCarriage),
                SaleItemData::make($productBabyChair),
            ]
        );

        SaleOrderData::persisted(
            $this->user,
            [
                'sale_order_id' => '101',
                'purchase_order_id' => '11',
                'store_id' => '1234567',
                'total_profit' => 20.0,
                'total_value' => 100.0,
            ],
            [
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
                SaleItemData::make($productBabyPacifier),
            ]
        );

        SaleOrderData::persisted(
            $this->user,
            [
                'sale_order_id' => '101',
                'purchase_order_id' => '11',
                'store_id' => '1234567',
                'total_profit' => 120.0,
                'total_value' => 899.0,
            ],
            [
                SaleItemData::make($productBabyCarriage),
            ]
        );
    }

    private function then_i_must_see_the_sales_list_page()
    {
        $this->response->assertViewIs('pages.sales.list');
        $this->response->assertViewHas('paginator');
        $this->response->assertViewHas('saleOrders', [
            [
                'saleOrderCode' => '101',
                'purchaseSaleOrderId' => '11',
                'storeSaleOrderId' => '12',
                'selledAt' => '12/12/2021',
                'store' => '',
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
                'store' => '',
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
            [
                'saleOrderCode' => '100',
                'purchaseSaleOrderId' => '10',
                'storeSaleOrderId' => '12',
                'selledAt' => '12/12/2021',
                'store' => '',
                'value' => 'R$ 1.450,00',
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
                'productsValue' => 1.0,
                'profit' => 'R$ 250,00',
                'status' => 'Registrada',
            ]
        ]);
        $this->response->assertViewHas('total', [
            'beginDate' => '01/01/1970',
            'endDate' => '31/12/9999',
            'salesCount' => 3,
            'productsCount' => 8,
            'storesCount' => [],
            'value' => 'R$ 2.449,00',
            'profit' => 'R$ 390,00',
        ]);
    }

    private function when_i_want_to_see_those_sales()
    {
        $this->response = $this->get('/vendas/lista');

    }
}
