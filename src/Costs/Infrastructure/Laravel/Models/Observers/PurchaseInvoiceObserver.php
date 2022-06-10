<?php

namespace Src\Costs\Infrastructure\Laravel\Models\Observers;

use Ramsey\Uuid\Uuid;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;

class PurchaseInvoiceObserver
{
    public function creating(PurchaseInvoice $purchaseInvoice): void
    {
        if (!$purchaseInvoice->uuid) {
            $purchaseInvoice->uuid = Uuid::uuid4();
        }
    }
}
