<?php

namespace Tests\Costs\Unit\Domain\UseCases;

use Mockery as m;
use SimpleXMLElement;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Domain\UseCases\SynchronizePurchaseItems;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\TestCase;

class SynchronizePurchaseItemsTest extends TestCase
{
    public function test_should_sync(): void
    {
        // Arrange
        $dbRepository = m::mock(Repository::class);
        $nfeReader = m::mock(NFeRepository::class);

        $synchronizePurchaseItems = new SynchronizePurchaseItems(
            $dbRepository,
            $nfeReader
        );


        $purchaseInvoice = PurchaseInvoiceData::make();
        $purchaseInvoices = [$purchaseInvoice];
        $xml = new SimpleXMLElement('<xml></xml>');
        $items = [
            PurchaseItemsData::make(),
            PurchaseItemsData::make(),
            PurchaseItemsData::make(),
        ];

        // Expects
        $dbRepository->expects()
            ->listPurchaseInvoice()
            ->andReturn($purchaseInvoices);

        $dbRepository->expects()
            ->getXml($purchaseInvoice)
            ->andReturn($xml);

        $nfeReader->expects()
            ->getPurchaseItems($xml)
            ->andReturn($items);

        $dbRepository->expects()
            ->insertPurchaseItem($purchaseInvoice, m::type(PurchaseItem::class))
            ->times(3)
            ->andReturnTrue();

        // Act
        $synchronizePurchaseItems->sync();
    }
}
