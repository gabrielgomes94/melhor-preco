<?php

namespace Src\Costs\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_count_purchase_invoices(): void
    {
        // Arrange
        $user = UserData::persisted();
        PurchaseInvoiceData::makePersisted($user);
        PurchaseInvoiceData::makePersisted($user);
        PurchaseInvoiceData::makePersisted($user);
        PurchaseInvoiceData::makePersisted($user);

        $repository = app(Repository::class);

        // Act
        $result = $repository->countPurchaseInvoices($user->getId());

        // Assert
        $this->assertSame(4, $result);
    }

    public function test_should_get_last_synchronization_datetime(): void
    {
        // Arrange
        $user = UserData::persisted();
        PurchaseInvoiceData::makePersisted($user);
        $repository = app(Repository::class);

        // Act
        $result = $repository->getLastSynchronizationDateTime($user->getId());

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
    }

    public function test_should_not_get_last_synchronization_datetime_when_there_is_no_purchase_invoices(): void
    {
        // Arrange
        $user = UserData::persisted();
        $repository = app(Repository::class);

        // Act
        $result = $repository->getLastSynchronizationDateTime($user->getId());

        // Assert
        $this->assertNull($result);
    }

    public function test_get_purchase_invoice(): void
    {
        // Arrange
        $user = UserData::persisted();
        PurchaseInvoiceData::makePersisted($user, ['uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110']);
        $repository = app(Repository::class);

        // Act
        $result = $repository->getPurchaseInvoice($user->getId(), '9044ab84-a3bf-485e-ba17-6c9ea6f53110');

        // Assert
        $this->assertInstanceOf(PurchaseInvoice::class, $result);
    }

    public function test_should_get_purchase_item(): void
    {
        // Arrange
        $user = UserData::persisted();
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($user, ['uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110']);
        PurchaseItemsData::makePersisted($purchaseInvoice, [
            'uuid' => '16f3eb5f-5af4-419e-8f5d-225884a74d5c'
        ]);
        $repository = app(Repository::class);

        // Act
        $result = $repository->getPurchaseItem($user->getId(), '16f3eb5f-5af4-419e-8f5d-225884a74d5c');

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
        $repository = app(Repository::class);

        // Act
        $result = $repository->getXml($purchaseInvoice);

        // Assert
        $this->assertInstanceOf(SimpleXMLElement::class,$result);
    }

    public function test_should_insert_purchase_invoice(): void
    {
        // Arrange
        $user = UserData::persisted();
        $purchaseInvoice = PurchaseInvoiceData::make();
        $repository = app(Repository::class);

        // Act
        $result = $repository->insertPurchaseInvoice($purchaseInvoice, $user->id);

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_not_insert_purchase_invoice_when_it_already_exists(): void
    {
        // Arrange
        $user = UserData::persisted();
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($user);
        $repository = app(Repository::class);

        // Act
        $result = $repository->insertPurchaseInvoice($purchaseInvoice, $user->id);

        // Assert
        $this->assertFalse($result);
    }

    public function test_should_insert_purchase_item(): void
    {
        // Arrange
        $user = UserData::persisted();
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($user);
        $purchaseItem = PurchaseItemsData::make();
        $repository = app(Repository::class);

        // Act
        $result = $repository->insertPurchaseItem($purchaseInvoice, $purchaseItem);

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_list_purchase_invoice(): void
    {
        // Arrange
        $user = UserData::persisted();
        PurchaseInvoiceData::makePersisted($user);
        PurchaseInvoiceData::makePersisted($user);
        PurchaseInvoiceData::makePersisted($user);
        $repository = app(Repository::class);

        // Act
        $result = $repository->listPurchaseInvoice($user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(PurchaseInvoice::class, $result);
        $this->assertSame(3, count($result));
    }

    public function test_should_check_purchase_invoice_exists(): void
    {
        // Arrange
        $user = UserData::persisted();
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($user);
        $repository = app(Repository::class);

        // Act
        $result = $repository->purchaseInvoiceExists($purchaseInvoice);

        // Assert
        $this->assertTrue($result);
    }

    public function test_should_get_product_costs(): void
    {
        // Arrange
        $user = UserData::persisted();
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($user);
        $product = ProductData::babyCarriage($user);
        PurchaseItemsData::makePersisted($purchaseInvoice, [], $product);

        $repository = app(Repository::class);

        // Act
        $result = $repository->getProductCosts('1234', $user->getId());

        // Assert
        $this->assertInstanceOf(ProductCosts::class, $result);
        $this->assertContainsOnlyInstancesOf(PurchaseItem::class, $result->purchaseItemCosts);
    }

    public function test_should_not_get_product_costs_when_product_doest_not_exists(): void
    {
        // Arrange
        $user = UserData::persisted();
        $repository = app(Repository::class);

        // Expect
        $this->expectException(ProductNotFoundException::class);

        // Act
        $repository->getProductCosts('1234', $user->getId());
    }
}
