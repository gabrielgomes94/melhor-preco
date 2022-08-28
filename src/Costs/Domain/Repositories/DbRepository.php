<?php

namespace Src\Costs\Domain\Repositories;

use Carbon\Carbon;
use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Models\PurchaseItem;

interface DbRepository
{
    public function getProductCosts(string $sku, string $userId): ProductCosts;

    public function countPurchaseInvoices(string $userId): int;

    public function getLastSynchronizationDateTime(string $userId): ?Carbon;

    public function getPurchaseInvoice(string $userId, string $uuid): ?PurchaseInvoice;

    public function getPurchaseItem(string $userId, string $uuid): ?PurchaseItem;

    public function insertPurchaseItem(
        PurchaseInvoice $purchaseInvoice,
        PurchaseItem $purchaseItem
    ): bool;

    public function insertPurchaseInvoice(PurchaseInvoice $purchaseInvoice, string $userId): bool;

    public function listPurchaseInvoice(string $userId): array;

    public function purchaseInvoiceExists(PurchaseInvoice $purchaseInvoice): bool;
}
