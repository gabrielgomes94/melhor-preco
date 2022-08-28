<?php

namespace Src\Costs\Domain\Services;

interface SyncPurchaseInvoices
{
    public function sync(string $userId): void;
}
