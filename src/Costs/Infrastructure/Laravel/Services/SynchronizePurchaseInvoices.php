<?php

namespace Src\Costs\Infrastructure\Laravel\Services;

use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\ErpRepository;
use Src\Costs\Domain\Services\SyncPurchaseInvoices;

class SynchronizePurchaseInvoices implements SyncPurchaseInvoices
{
    public function __construct(
        private DbRepository $repository,
        private ErpRepository $erpRepository
    )
    {
    }

    public function sync(string $userId): void
    {
        $data = $this->erpRepository->listPurchaseInvoice();

        foreach ($data as $purchaseInvoice) {
            $this->repository->insertPurchaseInvoice($purchaseInvoice, $userId);
        }
    }
}
