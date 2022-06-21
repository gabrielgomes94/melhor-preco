<?php

namespace Src\Costs\Domain\UseCases\Contracts;

interface SyncPurchaseInvoices
{
    public function sync(string $userId): void;
}
