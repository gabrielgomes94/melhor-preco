<?php

namespace Tests\Feature\Prices;

use Illuminate\Support\Facades\Queue;
use Src\Prices\Infrastructure\Laravel\Jobs\SyncPrices;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Feature\Users\Concerns\UsersDatabase;
use Tests\FeatureTestCase;

class SyncPricesTest extends FeatureTestCase
{
    use UsersDatabase;

    public function test_should_sync_prices_in_marketplace(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_a_queue_setup();
        $this->given_i_have_a_marketplace();

        $this->when_i_want_to_sync_prices_in_marketplace();

        $this->then_the_sync_prices_job_must_be_queued();
        $this->then_it_must_be_redirected();
    }

    public function test_should_sync_prices_in_all_marketplaces(): void
    {
        $this->given_i_am_a_logged_user();
        $this->given_i_have_a_queue_setup();
        $this->given_i_have_many_marketplaces();

        $this->when_i_want_to_sync_prices_in_all_marketplaces();

        $this->then_the_sync_prices_job_must_be_queued_for_all_marketplaces();
        $this->then_it_must_be_redirected();
    }

    private function given_i_have_a_queue_setup(): void
    {
        Queue::fake();
    }

    private function given_i_have_a_marketplace(): void
    {
        MarketplaceData::magalu($this->user);
    }

    private function given_i_have_many_marketplaces(): void
    {
        MarketplaceData::magalu($this->user);
        MarketplaceData::shopee($this->user);
        MarketplaceData::olist($this->user);
    }

    private function then_the_sync_prices_job_must_be_queued(): void
    {
        Queue::assertPushed(SyncPrices::class, 2);
    }

    private function then_the_sync_prices_job_must_be_queued_for_all_marketplaces(): void
    {
        Queue::assertPushed(SyncPrices::class, 6);
    }

    private function then_it_must_be_redirected(): void
    {
        $this->response->assertRedirect();
    }

    private function when_i_want_to_sync_prices_in_marketplace(): void
    {
        $this->response = $this->post('/calculadora/magalu/sincronizar');
    }

    private function when_i_want_to_sync_prices_in_all_marketplaces()
    {
        $this->response = $this->post('/calculadora/sincronizar');
    }
}
