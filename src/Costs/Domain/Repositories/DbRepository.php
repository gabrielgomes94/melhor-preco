<?php

namespace Src\Costs\Domain\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;

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

    public function listPurchaseInvoice(): Collection;

    public function linkItemToProduct(PurchaseItem $item, string $productSku): bool;

    public function purchaseInvoiceExists(PurchaseInvoice $purchaseInvoice): bool;
}
