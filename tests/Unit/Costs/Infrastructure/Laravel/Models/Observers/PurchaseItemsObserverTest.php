<?php

namespace Tests\Unit\Costs\Infrastructure\Laravel\Models\Observers;

use Src\Costs\Infrastructure\Laravel\Models\Observers\PurchaseItemsObserver;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Helpers\AssertUuidHelper;
use Tests\TestCase;

class PurchaseItemsObserverTest extends TestCase
{
    use AssertUuidHelper;

    public function test_creating_method_should_set_uuid(): void
    {
        // Arrange
        $purchaseItem = PurchaseItemsData::make();
        $observer = new PurchaseItemsObserver();

        // Act
        $observer->creating($purchaseItem);

        // Assert
        $this->assertNotNull($purchaseItem->uuid);
        $this->assertIsUuid($purchaseItem->uuid);
    }
}
