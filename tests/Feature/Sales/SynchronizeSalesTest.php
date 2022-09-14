<?php

namespace Tests\Feature\Sales;

use Illuminate\Support\Facades\Queue;
use Src\Sales\Infrastructure\Laravel\Jobs\SyncSales;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class SynchronizeSalesTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_synchronize_sales(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_a_queue_setup();

        $this->when_i_want_to_sync_sales();

        $this->then_the_sync_sales_job_must_be_queued();
        $this->then_i_must_be_redirected();
    }

    private function given_i_have_a_queue_setup(): void
    {
        Queue::fake();
    }

    private function when_i_want_to_sync_sales()
    {
        $this->response = $this->post('vendas/sincronizar');
    }

    private function then_the_sync_sales_job_must_be_queued(): void
    {
        Queue::assertPushed(SyncSales::class);
    }

    private function then_i_must_be_redirected(): void
    {
        $this->response->assertRedirect();
    }
}
