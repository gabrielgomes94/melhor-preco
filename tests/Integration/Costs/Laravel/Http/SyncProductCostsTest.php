<?php

namespace Tests\Integration\Costs\Laravel\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\TestResponse;
use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

// @todo: escrever um teste de feature mais completo: simular requisição na API do Bling e verificar se salva no banco
class SyncProductCostsTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = UserData::make();
        Bus::fake();
    }

    public function test_should_sync_costs(): void
    {
        $this->when_i_want_to_sync_costs_data();

        $this->then_a_sync_costs_job_must_be_dispatched();
        $this->and_then_the_user_must_be_redirected_to_list_purchase_invoices_page();
    }

    private function when_i_want_to_sync_costs_data(): void
    {
        $this->response = $this
            ->actingAs($this->user)
            ->post('/custos/sincronizar');
    }

    private function then_a_sync_costs_job_must_be_dispatched(): void
    {
        Bus::assertDispatched(SyncCosts::class);
    }

    private function and_then_the_user_must_be_redirected_to_list_purchase_invoices_page(): void
    {
        $this->response->assertRedirect('custos/notas-fiscais/lista');
    }
}
