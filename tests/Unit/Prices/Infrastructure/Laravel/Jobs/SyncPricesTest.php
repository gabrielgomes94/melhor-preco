<?php

namespace Src\Prices\Infrastructure\Laravel\Jobs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Src\Prices\Infrastructure\Laravel\Services\SynchronizeFromMarketplace;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SyncPricesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_synchronize_price_and_dispatch_job_for_next_page(): void
    {
        // Arrange
        Queue::fake();
        $synchronizeFromMarketplace = Mockery::mock(SynchronizeFromMarketplace::class);
        $user = UserData::persisted();
        $marketplace = MarketplaceData::magalu($user);
        $job = new SyncPrices($marketplace, 1, 'active');

        // Expect
        $synchronizeFromMarketplace->expects()
            ->sync($marketplace, 1, 'active')
            ->andReturnTrue();

        // Act
        $job->handle($synchronizeFromMarketplace);

        // Assert
        Queue::assertPushed(SyncPrices::class);
    }

    public function test_should_dispatch_job_for_next_page_when_page_is_less_than_minimum_value(): void
    {
        // Arrange
        Queue::fake();
        $synchronizeFromMarketplace = Mockery::mock(SynchronizeFromMarketplace::class);
        $user = UserData::persisted();
        $marketplace = MarketplaceData::magalu($user);
        $job = new SyncPrices($marketplace, 1, 'active');

        // Expect
        $synchronizeFromMarketplace->expects()
            ->sync($marketplace, 1, 'active')
            ->andReturnFalse();

        // Act
        $job->handle($synchronizeFromMarketplace);

        // Assert
        Queue::assertPushed(SyncPrices::class);
    }

    public function test_should_not_dispatch_job_for_next_page(): void
    {
        // Arrange
        Queue::fake();
        $synchronizeFromMarketplace = Mockery::mock(SynchronizeFromMarketplace::class);
        $user = UserData::persisted();
        $marketplace = MarketplaceData::magalu($user);
        $job = new SyncPrices($marketplace, 11, 'active');

        // Expect
        $synchronizeFromMarketplace->expects()
            ->sync($marketplace, 11, 'active')
            ->andReturnFalse();

        // Act
        $job->handle($synchronizeFromMarketplace);

        // Assert
        Queue::assertNotPushed(SyncPrices::class);
    }
}
