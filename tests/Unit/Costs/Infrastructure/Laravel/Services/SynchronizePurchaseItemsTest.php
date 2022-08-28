<?php

namespace Src\Costs\Infrastructure\Laravel\Services;

use Mockery as m;
use SimpleXMLElement;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Infrastructure\Laravel\Services\SynchronizePurchaseItems;
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
            ->listPurchaseInvoice('1')
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
        $synchronizePurchaseItems->sync('1');
    }
}
