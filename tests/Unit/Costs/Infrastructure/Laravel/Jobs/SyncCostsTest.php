<?php

namespace Src\Costs\Infrastructure\Laravel\Jobs;

use Mockery as m;
use Src\Costs\Domain\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Domain\UseCases\SynchronizePurchaseItems;
use Tests\TestCase;

class SyncCostsTest extends TestCase
{
    public function test_should_handle(): void
    {
        // Arrange
        $job = new SyncCosts();
        $synchronizePurchaseInvoices = m::mock(SynchronizePurchaseInvoices::class);
        $synchronizePurchaseItems = m::mock(SynchronizePurchaseItems::class);

        // Expect
        $synchronizePurchaseInvoices->expects()
            ->sync()
            ->andReturnNull();

        $synchronizePurchaseItems->expects()
            ->sync()
            ->andReturnNull();

        // Act
        $job->handle($synchronizePurchaseInvoices, $synchronizePurchaseItems);
    }
}
