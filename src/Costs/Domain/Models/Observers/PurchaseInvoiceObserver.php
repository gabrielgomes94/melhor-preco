<?php

namespace Src\Costs\Domain\Models\Observers;

use Ramsey\Uuid\Uuid;
use Src\Costs\Domain\Models\PurchaseInvoice;

class PurchaseInvoiceObserver
{
    public function creating(PurchaseInvoice $purchaseInvoice)
    {
        $purchaseInvoice->uuid = Uuid::uuid4();
    }
}