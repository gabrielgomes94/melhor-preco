<?php

namespace Src\Costs\Infrastructure\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Src\costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Models\PurchaseItem;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Infrastructure\Logging\Logging;
use Throwable;

class Repository implements DbRepository
{
    public function listPurchaseInvoice(): Collection
    {
        return PurchaseInvoice::all();
    }

    public function getXml(PurchaseInvoice $purchaseInvoice): SimpleXMLElement
    {
        $data = Http::get($purchaseInvoice->getXmlUrl());

        return new SimpleXMLElement($data->body());
    }

    public function getPurchaseInvoice(string $uuid): ?PurchaseInvoice
    {
        return PurchaseInvoice::where('uuid', $uuid)->first();
    }

    public function getPurchaseItem(string $uuid): ?PurchaseItem
    {
        return PurchaseItem::where('uuid', $uuid)->first();
    }

    public function insertPurchaseItem(PurchaseInvoice $purchaseInvoice, array $item): bool
    {
        $purchaseItem = new PurchaseItem($item);

        try {
            $purchaseInvoice->items()->save($purchaseItem);
            Logging::logSuccessfulItemSync($purchaseItem, $purchaseInvoice);

            return true;
        } catch (Throwable $exception) {
            Logging::logFailedItemSync($purchaseItem, $purchaseInvoice, $exception);
        }

        return false;
    }

    public function linkItemToProduct(PurchaseItem $item, string $productSku): bool
    {
        $item->product_sku = $productSku;
        $result = $item->save();

        $result
            ? Logging::logSuccessfulItemToProductLink($item, $productSku)
            : Logging::logFailedItemToProductLink($item, $productSku);

        return $result;
    }

    public function purchaseInvoiceExists(PurchaseInvoice $purchaseInvoice): bool
    {
        return (bool) PurchaseInvoice::where([
            'access_key' => $purchaseInvoice->getAccessKey(),
            'number' => $purchaseInvoice->getNumber(),
            'series' => $purchaseInvoice->getSeries(),
        ])->first();
    }

    public function countPurchaseInvoices(): int
    {
        return PurchaseInvoice::count();
    }

    public function getLastSynchronizationDateTime(): Carbon
    {
        return PurchaseInvoice::query()->orderBy('updated_at')->first()->getLastUpdate();
    }
}
