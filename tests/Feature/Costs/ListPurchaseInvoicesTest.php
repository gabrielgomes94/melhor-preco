<?php

namespace Tests\Feature\Costs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ListPurchaseInvoicesTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = UserData::make();
    }

    public function test_should_list_purchase_invoices(): void
    {
        $this->given_i_have_a_bunch_of_purchase_invoices();

        $this->when_i_want_to_see_them_listed();

        $this->then_i_must_be_sent_to_invoices_list_page();
    }

    private function given_i_have_a_bunch_of_purchase_invoices(): void
    {
        PurchaseInvoiceData::makePersisted($this->user, [
            'uuid' => '8556b473-602d-4b59-954f-44f9b78526af'
        ]);
        PurchaseInvoiceData::makePersisted($this->user, [
            'uuid' => 'e376571c-daff-43cb-b54e-0eb51396f179',
            'value' => 2500.0,
            'number' => '248285',
        ]);
        PurchaseInvoiceData::makePersisted($this->user, [
            'uuid' => '8d56958e-4006-4cbf-af24-dce3daeb2da7',
            'value' => 1750.0,
            'number' => '248286',
        ]);
    }

    private function when_i_want_to_see_them_listed(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->get('/custos/notas-fiscais/lista');
    }

    private function then_i_must_be_sent_to_invoices_list_page(): void
    {
        $this->response->assertViewIs('pages.costs.invoices.list');
        $this->response->assertViewHas('data', [
            [
                'uuid' => '8556b473-602d-4b59-954f-44f9b78526af',
                'series' => '1',
                'seriesNumber' => '1 - 248284',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 1.000,00',
                'status' => 'Registrada',
            ],
            [
                'uuid' => 'e376571c-daff-43cb-b54e-0eb51396f179',
                'series' => '1',
                'seriesNumber' => '1 - 248285',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 2.500,00',
                'status' => 'Registrada',
            ],
            [
                'uuid' => '8d56958e-4006-4cbf-af24-dce3daeb2da7',
                'series' => '1',
                'seriesNumber' => '1 - 248286',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 1.750,00',
                'status' => 'Registrada',
            ],
        ]);
    }
}
