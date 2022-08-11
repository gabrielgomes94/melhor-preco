<?php

namespace Src\Costs\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Costs\Domain\Models\Contracts\PurchaseItem;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice as PurchaseInvoiceModel;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem as PurchaseItemModel;
use Src\Costs\Domain\Repositories\DbRepository;

class Repository implements DbRepository
{
    public function countPurchaseInvoices(string $userId): int
    {
        return PurchaseInvoiceModel::fromUser($userId)->count();
    }

    public function getLastSynchronizationDateTime(string $userId): ?Carbon
    {
        return PurchaseInvoiceModel::fromUser($userId)
            ->orderByDesc('updated_at')
            ->first()
            ?->getLastUpdate();
    }

    public function getPurchaseInvoice(string $uuid): ?PurchaseInvoice
    {
        return PurchaseInvoiceModel::where('uuid', $uuid)->first();
    }

    public function getPurchaseItem(string $uuid): ?PurchaseItem
    {
        return PurchaseItemModel::where('uuid', $uuid)->first();
    }

    public function getXml(PurchaseInvoice $purchaseInvoice): SimpleXMLElement
    {
        $data = Http::get($purchaseInvoice->getXmlUrl());

        return new SimpleXMLElement($data->body());
    }

    public function insertPurchaseInvoice(PurchaseInvoice $purchaseInvoice, string $userId): bool
    {
        if ($this->purchaseInvoiceExists($purchaseInvoice)) {
            return false;
        }

        $purchaseInvoice->user_id = $userId;

        return $purchaseInvoice->save();
    }

    public function insertPurchaseItem(PurchaseInvoice $purchaseInvoice, PurchaseItem $purchaseItem): bool
    {
        return (bool) $purchaseInvoice->items()->save($purchaseItem);
    }

    public function linkItemToProduct(PurchaseItem $item, string $productSku): bool
    {
        $item->product_sku = $productSku;

        return $item->save();
    }

    /**
     * @return PurchaseInvoiceModel[]
     */
    public function listPurchaseInvoice(): array
    {
        return PurchaseInvoiceModel::all()->all();
    }

    public function purchaseInvoiceExists(PurchaseInvoice $purchaseInvoice): bool
    {
        return (bool) PurchaseInvoiceModel::where([
            'access_key' => $purchaseInvoice->getAccessKey(),
            'number' => $purchaseInvoice->getNumber(),
            'series' => $purchaseInvoice->getSeries(),
        ])->first();
    }
}
