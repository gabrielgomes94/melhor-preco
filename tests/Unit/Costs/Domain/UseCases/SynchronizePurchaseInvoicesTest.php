<?php

namespace Src\Costs\Domain\UseCases;

use Mockery as m;
use Src\Costs\Infrastructure\Bling\BlingRepository;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\TestCase;

class SynchronizePurchaseInvoicesTest extends TestCase
{
    public function test_should_sync(): void
    {
        // Arrange
        $dbRepository = m::mock(Repository::class);
        $erpRepository = m::mock(BlingRepository::class);
        $synchronizePurchaseInvoices = new SynchronizePurchaseInvoices($dbRepository, $erpRepository);

        $purchaseInvoicesFromERP = [
            PurchaseInvoiceData::make(),
            PurchaseInvoiceData::make([
                'number' => '248285',
                'value' => 900.0,
            ]),
            PurchaseInvoiceData::make([
                'number' => '248286',
                'value' => 1800.0,
            ]),
        ];

        // Expects
        $erpRepository->expects()
            ->listPurchaseInvoice()
            ->andReturn($purchaseInvoicesFromERP);

        $dbRepository->expects()
            ->insertPurchaseInvoice(m::type(PurchaseInvoice::class))
            ->times(3)
            ->andReturnTrue();

        // Act
        $synchronizePurchaseInvoices->sync();
    }
}
