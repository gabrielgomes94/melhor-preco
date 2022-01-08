<?php

namespace Src\Costs\Domain\Repositories;

use Illuminate\Support\Collection;
use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Models\PurchaseItem;

interface DbRepository
{
    public function getPurchaseInvoice(string $uuid): ?PurchaseInvoice;

    public function getPurchaseItem(string $uuid): ?PurchaseItem;

    public function insertPurchaseItem(PurchaseInvoice $purchaseInvoice, array $item): bool;

    public function listPurchaseInvoice(): Collection;

    public function linkItemToProduct(PurchaseItem $item, string $productSku): bool;

    public function purchaseInvoiceExists(PurchaseInvoice $purchaseInvoice): bool;
}
