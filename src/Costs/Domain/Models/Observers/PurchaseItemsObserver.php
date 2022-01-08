<?php

namespace Src\Costs\Domain\Models\Observers;

use Ramsey\Uuid\Uuid;
use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\costs\Domain\Models\PurchaseItems;

class PurchaseItemsObserver
{
    public function creating(PurchaseItems $purchaseItem)
    {
        $purchaseItem->uuid = Uuid::uuid4();
    }
}
