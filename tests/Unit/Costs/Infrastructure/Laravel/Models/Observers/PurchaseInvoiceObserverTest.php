<?php

namespace Src\Costs\Infrastructure\Laravel\Models\Observers;

use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Helpers\AssertUuidHelper;
use Tests\TestCase;

class PurchaseInvoiceObserverTest extends TestCase
{
    use AssertUuidHelper;

    public function test_creating_method_should_set_uuid(): void
    {
        // Arrange
        $purchaseInvoice = PurchaseInvoiceData::make();
        $observer = new PurchaseInvoiceObserver();

        // Act
        $observer->creating($purchaseInvoice);

        // Assert
        $this->assertNotNull($purchaseInvoice->uuid);
        $this->assertIsUuid($purchaseInvoice->uuid);
    }
}
