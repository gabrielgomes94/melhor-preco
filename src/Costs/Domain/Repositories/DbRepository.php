<?php

namespace Src\Costs\Domain\Repositories;

use Carbon\Carbon;
use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Costs\Domain\Models\Contracts\PurchaseItem;

interface DbRepository
{
    public function countPurchaseInvoices(): int;

    public function getLastSynchronizationDateTime(): ?Carbon;

    public function getPurchaseInvoice(string $uuid): ?PurchaseInvoice;

    public function getPurchaseItem(string $uuid): ?PurchaseItem;

    public function insertPurchaseItem(
        PurchaseInvoice $purchaseInvoice,
        PurchaseItem $purchaseItem
    ): bool;

    public function insertPurchaseInvoice(PurchaseInvoice $purchaseInvoice): bool;

    public function listPurchaseInvoice(): array;

    public function linkItemToProduct(PurchaseItem $item, string $productSku): bool;

    public function purchaseInvoiceExists(PurchaseInvoice $purchaseInvoice): bool;
}
