<?php

namespace Src\costs\Domain\UseCases;

interface SyncPurchaseInvoices
{
    public function sync(): void;

    public function syncPurchaseItems(): void;
}
