<?php

namespace Tests\Feature\Costs;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
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
        $this->and_given_this_product_has_some_purchase_invoice();

        $this->when_i_want_to_see_its_costs_details();

        $this->then_i_must_be_sent_to_costs_product_show_page();
    }

    private function given_i_have_a_product_with_purchase_item(): void
    {
        ProductData::makePersisted([
            'sku' => 1,
            'purchase_price' => 50,
            'tax_icms' => 12,
            'additional_costs' => 0,
            'ean' => '12345678910'
        ]);

        $purchaseInvoice = PurchaseInvoiceData::makePersisted();
        PurchaseItemsData::makePersisted($purchaseInvoice);
    }

    private function when_i_want_to_see_its_costs_details(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/custos/produtos/detalhes/1');
    }

    private function then_i_must_be_sent_to_costs_product_show_page(): void
    {
        $this->response->assertViewIs('pages.costs.products.show');
        $this->response->assertViewHas('costs', [
            [
                'issuedAt' => '17/02/2021 09:55',
                'unitCost' => 'R$ 100,00',
                'quantity' => 5.0,
                'supplierName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'supplierFiscalId' => '06981862000200',
                'costs' => [
                    'purchasePrice' => 'R$ 150,00',
                    'taxes' => 'R$ 40,00',
                    'freight' => 'R$ 10,00',
                    'insurance' => 'R$ 0,00',
                    'icms' => '0,00 %',
                ],
            ],
        ]);
        $this->response->assertViewHas('product', [
            'name' => 'Canguru Balbi Vermelho',
            'sku' => '1',
        ]);
    }

    private function and_given_this_product_has_some_purchase_invoice(): void
    {

    }
}
