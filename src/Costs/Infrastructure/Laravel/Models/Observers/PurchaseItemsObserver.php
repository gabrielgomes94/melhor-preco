<?php

namespace Src\Costs\Infrastructure\Laravel\Models\Observers;

use Ramsey\Uuid\Uuid;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;

class PurchaseItemsObserver
{
    public function creating(PurchaseItem $purchaseItem): void
    {
        if (!$purchaseItem->uuid) {
            $purchaseItem->uuid = Uuid::uuid4();
        }
    }
}
