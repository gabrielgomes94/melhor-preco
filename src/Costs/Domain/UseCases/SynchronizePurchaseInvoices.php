<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Domain\UseCases\Contracts\SyncPurchaseInvoices;

class SynchronizePurchaseInvoices implements SyncPurchaseInvoices
{
    public function __construct(
        private DbRepository $repository,
        private ErpRepository $erpRepository
    )
    {
    }

    public function sync(): void
    {
        $data = $this->erpRepository->listPurchaseInvoice();

        foreach ($data as $purchaseInvoice) {
            $this->repository->insertPurchaseInvoice($purchaseInvoice);
        }
    }
}
