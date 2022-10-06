<?php

namespace Tests\Feature\Sales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Databases\SalesDatabase;
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
        SalesDatabase::setup($this->user);
    }

    private function then_i_must_see_the_sales_list_page()
    {
        $this->response->assertViewIs('pages.sales.list');
        $this->response->assertViewHas('paginator');
        $this->response->assertViewHas('saleOrders', [
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
        ]);
        $this->response->assertViewHas('total', [
            'beginDate' => null,
            'endDate' => null,
            'salesCount' => 5,
            'productsCount' => 6,
            'storesCount' => [
                'shopee' => [
                    'count' => 0,
                    'name' => 'Shopee',
                ],
            ],
            'value' => 'R$ 4.551,55',
            'profit' => 'R$ 556,00',
        ]);
    }

    private function when_i_want_to_see_those_sales()
    {
        $this->response = $this->get('/vendas/lista');

    }
}
