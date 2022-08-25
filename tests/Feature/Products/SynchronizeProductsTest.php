<?php

namespace Tests\Feature\Products;

use Illuminate\Support\Facades\Queue;
use Src\Products\Infrastructure\Laravel\Jobs\SyncProductsTest;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class SynchronizeProductsTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_synchronize_products(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_a_queue_setup();

        $this->when_i_want_to_sync_products();

        $this->then_the_sync_products_job_must_be_queued();
        $this->then_i_must_be_redirected();
    }

    private function given_i_have_a_queue_setup(): void
    {
        Queue::fake();
    }

    private function when_i_want_to_sync_products(): void
    {
        $this->response = $this->put('/produtos/sincronizar');
    }

    private function then_the_sync_products_job_must_be_queued(): void
    {
        Queue::assertPushed(SyncProductsTest::class);
    }

    private function then_i_must_be_redirected(): void
    {
        $this->response->assertRedirect();
    }
}
