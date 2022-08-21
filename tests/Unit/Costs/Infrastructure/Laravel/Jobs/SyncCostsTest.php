<?php

namespace Tests\Unit\Costs\Infrastructure\Laravel\Jobs;

use Mockery as m;
use Src\Costs\Domain\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Domain\UseCases\SynchronizePurchaseItems;
use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\TestCase;

class SyncCostsTest extends TestCase
{
    public function test_should_handle(): void
    {
        // Arrange
        $job = new SyncCosts('some-user-id');
        $synchronizePurchaseInvoices = m::mock(SynchronizePurchaseInvoices::class);
        $synchronizePurchaseItems = m::mock(SynchronizePurchaseItems::class);

        $user = new User();

        // Expect
        $synchronizePurchaseInvoices->expects()
            ->sync('some-user-id')
            ->andReturnNull();

        $synchronizePurchaseItems->expects()
            ->sync('some-user-id')
            ->andReturnNull();

        // Act
        $job->handle($synchronizePurchaseInvoices, $synchronizePurchaseItems);
    }
}
