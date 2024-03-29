<?php

namespace Src\Costs\Infrastructure\Laravel\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Models\PurchaseItem;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice as PurchaseInvoiceModel;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem as PurchaseItemModel;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Infrastructure\Laravel\Repositories\ProductRepository;

class Repository implements DbRepository
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

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

    public function getPurchaseInvoice(string $userId, string $uuid): ?PurchaseInvoice
    {
        return PurchaseInvoiceModel::fromUser($userId)
            ->where('uuid', $uuid)
            ->first();
    }

    public function getPurchaseItem(string $userId, string $uuid): ?PurchaseItem
    {
        $item = PurchaseItemModel::where('uuid', $uuid)->first();

        if ($item?->getUserId() === $userId) {
            return $item;
        }

        return null;
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
        $purchaseInvoice->items()->save($purchaseItem);

        $product = $this->productRepository->getProductByEan(
            $purchaseItem->getEan(),
            $purchaseInvoice->getUser()->getId()
        );

        if ($product) {
            $purchaseItem->product()->associate($product);
            $purchaseItem->save();
        }

        return true;
    }

    /**
     * @return PurchaseInvoiceModel[]
     */
    public function listPurchaseInvoice(string $userId): array
    {
        return PurchaseInvoiceModel::fromUser($userId)->get()->all();
    }

    public function purchaseInvoiceExists(PurchaseInvoice $purchaseInvoice): bool
    {
        return (bool) PurchaseInvoiceModel::where([
            'access_key' => $purchaseInvoice->getAccessKey(),
            'number' => $purchaseInvoice->getNumber(),
            'series' => $purchaseInvoice->getSeries(),
        ])->first();
    }

    /**
     * @throws ProductNotFoundException
     */
    public function getProductCosts(string $sku, string $userId): ProductCosts
    {
        if (!$product = $this->productRepository->get($sku, $userId)) {
            throw new ProductNotFoundException($sku, $userId);
        }

        $items = collect($product->getPurchaseItemsCosts());
        $items = $items->sortByDesc(
            fn (PurchaseItem $item) => $item->getIssuedAt()
        )->all();

        return new ProductCosts($product, $items);
    }
}
