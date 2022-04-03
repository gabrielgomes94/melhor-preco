<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Domain\UseCases\Contracts\SyncPurchaseInvoices;

class SynchronizePurchaseInvoices implements SyncPurchaseInvoices
{
    private DbRepository $repository;
    private ErpRepository $erpRepository;

    public function __construct(DbRepository $repository, ErpRepository $erpRepository)
    {
        $this->repository = $repository;
        $this->erpRepository = $erpRepository;
    }

    public function sync(): void
    {
        $data = $this->erpRepository->listPurchaseInvoice();

        foreach ($data as $purchaseInvoice) {
            if ($this->repository->purchaseInvoiceExists($purchaseInvoice)) {
                continue;
            }

            $purchaseInvoice->save();
        }
    }
}
