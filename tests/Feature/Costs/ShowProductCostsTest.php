<?php

namespace Tests\Feature\Costs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ShowProductCostsTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = UserData::make();
    }

    public function test_show_product_costs(): void
    {
        $this->given_i_have_a_product_with_purchase_item();

        $this->when_i_want_to_see_its_costs_details();

        $this->then_i_must_be_sent_to_costs_product_show_page();
    }

    private function given_i_have_a_product_with_purchase_item(): void
    {
        $product = ProductData::babyCarriage($this->user);

        $purchaseInvoice = PurchaseInvoiceData::makePersisted($this->user);
        PurchaseItemsData::makePersisted($purchaseInvoice, [
            'uuid' => 'f0043355-92b8-4716-89b6-4e6b0c1c8c71'
        ], $product);
    }

    private function when_i_want_to_see_its_costs_details(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/custos/produtos/detalhes/1234');
    }

    private function then_i_must_be_sent_to_costs_product_show_page(): void
    {
        $this->response->assertViewIs('pages.costs.products.show');
        $this->response->assertViewHas('costs', [
            [
                'issuedAt' => '17/02/2021 09:55',
                'unitCost' => 'R$ 168,00',
                'quantity' => 5.0,
                'costs' => [
                    'purchasePrice' => 'R$ 150,00',
                    'taxes' => 'R$ 40,00',
                    'freight' => 'R$ 10,00',
                    'insurance' => '',
                    'icms' => '0,00 %',
                ],
                'supplier' => [
                    'name' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                    'fiscalId' => '06981862000200',
                ],
                'name' => 'Canguru Balbi Vermelho',
                'purchasePrice' => 'R$ 150,00',
                'totalValue' => 'R$ 840,00',
                'purchaseItemUuid' => 'f0043355-92b8-4716-89b6-4e6b0c1c8c71',
                'productSku' => '1234',
            ],
        ]);
        $this->response->assertViewHas('product', [
            'name' => 'Carrinho de Bebê',
            'sku' => '1234',
        ]);
    }
}
