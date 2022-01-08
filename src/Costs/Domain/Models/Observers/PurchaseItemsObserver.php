<?php

namespace Src\Costs\Domain\Models\Observers;

use Ramsey\Uuid\Uuid;
use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\costs\Domain\Models\PurchaseItem;

class PurchaseItemsObserver
{
    public function creating(PurchaseItem $purchaseItem)
    {
        $purchaseItem->uuid = Uuid::uuid4();
    }
}
