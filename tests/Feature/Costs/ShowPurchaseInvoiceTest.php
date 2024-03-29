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

class ShowPurchaseInvoiceTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = UserData::persisted();
    }

    public function test_should_show_purchase_invoices_detailed(): void
    {
        $this->given_i_have_a_purchase_invoice();

        $this->when_i_want_to_see_it_detailed();

        $this->then_i_must_be_sent_to_invoices_detailed_page();
    }

    public function test_should_handle_errors_when_purchase_invoice_does_not_exists(): void
    {
        $this->given_i_do_not_have_a_purchase_invoice();

        $this->when_i_want_to_see_it_detailed();

        $this->then_i_must_see_the_error_404_page();
    }

    private function given_i_have_a_purchase_invoice(): void
    {
        $product = ProductData::babyCarriage($this->user);
        $purchaseInvoice = PurchaseInvoiceData::makePersisted(
            $this->user, [
            'uuid' => '8556b473-602d-4b59-954f-44f9b78526af'
        ]);

        PurchaseItemsData::makePersisted(
            $purchaseInvoice,
            ['uuid' => '517cce8a-e7c2-48d7-a052-5e10729c7c22'],
            $product
        );
    }

    private function given_i_do_not_have_a_purchase_invoice(): void
    {}

    private function when_i_want_to_see_it_detailed(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/custos/notas-fiscais/detalhes/8556b473-602d-4b59-954f-44f9b78526af');
    }

    private function then_i_must_be_sent_to_invoices_detailed_page(): void
    {
        $this->response->assertViewIs('pages.costs.invoices.show');
        $this->response->assertViewHas('data', [
            'uuid' => '8556b473-602d-4b59-954f-44f9b78526af',
            'series' => '1',
            'seriesNumber' => '1 - 248284',
            'issuedAt' => '17/02/2021',
            'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
            'value' => 'R$ 1.000,00',
            'status' => 'Registrada',
            'number' => '248284',
            'situation' => 'Registrada',
            'fiscalId' => '06981862000200',
            'freightValue' => 10.0,
            'insuranceValue' => 0.0,
            'items' => [
                [
                    'name' => 'Canguru Balbi Vermelho',
                    'purchasePrice' => 'R$ 150,00',
                    'quantity' => 5.0,
                    'totalValue' => 'R$ 840,00',
                    'purchaseItemUuid' => '517cce8a-e7c2-48d7-a052-5e10729c7c22',
                    'productSku' => '1234',
                    'issuedAt' => '17/02/2021 09:55',
                    'unitCost' => 'R$ 168,00',
                    'costs' => [
                        'purchasePrice' => 'R$ 150,00',
                        'taxes' => 'R$ 40,00',
                        'freight' => 'R$ 10,00',
                        'insurance' => 'R$ 0,00',
                        'icms' => '0,00 %',
                    ],
                    'supplier' => [
                        'name' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                        'fiscalId' => '06981862000200',
                    ],
                ],
            ],
        ]);
    }

    private function then_i_must_see_the_error_404_page(): void
    {
        $this->response->assertViewIs('pages.errors.purchase-invoice-404');
    }
}
