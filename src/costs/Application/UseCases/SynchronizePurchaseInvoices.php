<?php

namespace Src\Costs\Application\UseCases;

use Src\costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\costs\Domain\UseCases\SyncPurchaseInvoices;

class SynchronizePurchaseInvoices implements SyncPurchaseInvoices
{
    private ErpRepository $repository;

    public function __construct(ErpRepository $repository)
    {
        $this->repository = $repository;
    }

    public function sync(): void
    {
        $data = $this->repository->listPurchaseInvoice();

        foreach ($data as $purchaseInvoice) {
            if ($this->purchaseInvoiceExists($purchaseInvoice)) {
                continue;
            }

            $purchaseInvoice->save();
        }
    }

    private function purchaseInvoiceExists(mixed $purchaseInvoice): bool
    {
        return (bool) PurchaseInvoice::where([
            'access_key' => $purchaseInvoice->getAccessKey(),
            'number' => $purchaseInvoice->getNumber(),
            'series' => $purchaseInvoice->getSeries(),
        ])->first();
    }
}
