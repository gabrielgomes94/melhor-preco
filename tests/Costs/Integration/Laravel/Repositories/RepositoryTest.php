<?php

namespace Tests\Costs\Integration\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_count_purchase_invoices(): void
    {
        // Arrange
        PurchaseInvoiceData::makePersisted();
        PurchaseInvoiceData::makePersisted();
        PurchaseInvoiceData::makePersisted();
        PurchaseInvoiceData::makePersisted();

        $repository = new Repository();

        // Act
        $result = $repository->countPurchaseInvoices();

        // Assert
        $this->assertSame(4, $result);
    }

    public function test_should_get_last_synchronization_datetime(): void
    {
        // Arrange
        PurchaseInvoiceData::makePersisted();
        $repository = new Repository();

        // Act
        $result = $repository->getLastSynchronizationDateTime();

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
    }

    public function test_should_not_get_last_synchronization_datetime_when_there_is_no_purchase_invoices(): void
    {
        // Arrange
        $repository = new Repository();

        // Act
        $result = $repository->getLastSynchronizationDateTime();

        // Assert
        $this->assertNull($result);
    }

    public function test_get_purchase_invoice(): void
    {
        // Arrange
        PurchaseInvoiceData::makePersisted(['uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110']);
        $repository = new Repository();

        // Act
        $result = $repository->getPurchaseInvoice('9044ab84-a3bf-485e-ba17-6c9ea6f53110');

        // Assert
        $this->assertInstanceOf(PurchaseInvoice::class, $result);
    }

    public function test_should_get_purchase_item(): void
    {
        // Arrange
        $purchaseInvoice = PurchaseInvoiceData::make(['uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110']);
        PurchaseItemsData::makePersisted($purchaseInvoice, [
            'uuid' => '16f3eb5f-5af4-419e-8f5d-225884a74d5c'
        ]);
        $repository = new Repository();

        // Act
        $result = $repository->getPurchaseItem('16f3eb5f-5af4-419e-8f5d-225884a74d5c');

        // Assert
        $this->assertInstanceOf(PurchaseItem::class, $result);
    }

    public function test_get_xml(): void
    {
        // Arrange
        Http::fake([
            'bling.com.br/relatorios/nfe.xml.php?s&chaveAcesso=1234' => Http::response('<xml></xml>'),
        ]);
        $purchaseInvoice = PurchaseInvoiceData::make();
        $repository = new Repository();

        // Act
        $result = $repository->getXml($purchaseInvoice);

        // Assert
        $this->assertInstanceOf(SimpleXMLElement::class,$result);
    }

    public function test_should_insert_purchase_invoice(): void
    {
        // Arrange
        $purchaseInvoice = PurchaseInvoiceData::make();
        $repository = new Repository();

        // Act
        $result = $repository->insertPurchaseInvoice($purchaseInvoice);

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_not_insert_purchase_invoice_when_it_already_exists(): void
    {
        // Arrange
        $purchaseInvoice = PurchaseInvoiceData::makePersisted();
        $repository = new Repository();

        // Act
        $result = $repository->insertPurchaseInvoice($purchaseInvoice);

        // Assert
        $this->assertFalse($result);
    }

    public function test_should_insert_purchase_item(): void
    {
        // Arrange
        $purchaseInvoice = PurchaseInvoiceData::makePersisted();
        $purchaseItem = PurchaseItemsData::make();
        $repository = new Repository();

        // Act
        $result = $repository->insertPurchaseItem($purchaseInvoice, $purchaseItem);

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_link_item_to_product(): void
    {
        // Arrange
        $purchaseItem = PurchaseItemsData::makePersisted(
            PurchaseInvoiceData::makePersisted()
        );
        $repository = new Repository();

        // Act
        $result = $repository->linkItemToProduct($purchaseItem, '1234');

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_List_purchase_invoice(): void
    {
        // Arrange
        PurchaseInvoiceData::makePersisted();
        PurchaseInvoiceData::makePersisted();
        PurchaseInvoiceData::makePersisted();
        $repository = new Repository();

        // Act
        $result = $repository->listPurchaseInvoice();

        // Assert
        $this->assertContainsOnlyInstancesOf(PurchaseInvoice::class, $result);
        $this->assertSame(3, count($result));
    }

    public function test_should_check_purchase_invoice_exists(): void
    {
        // Arrange
        $purchaseInvoice = PurchaseInvoiceData::makePersisted();
        $repository = new Repository();

        // Act
        $result = $repository->purchaseInvoiceExists($purchaseInvoice);

        // Assert
        $this->assertTrue($result);
    }
}
