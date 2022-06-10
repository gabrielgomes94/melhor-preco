<?php

namespace Tests\Costs\Unit\Infrastructure\Laravel\Models\Observers;

use Src\Costs\Infrastructure\Laravel\Models\Observers\PurchaseInvoiceObserver;
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
