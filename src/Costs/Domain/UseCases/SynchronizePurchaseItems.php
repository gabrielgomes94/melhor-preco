<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Domain\UseCases\Contracts\SyncPurchaseItems;

class SynchronizePurchaseItems implements SyncPurchaseItems
{
    public function __construct(
        private DbRepository $repository,
        private NFeRepository $nfeReader,
    )
    {
    }

    public function sync(string $userId): void
    {
        $data = $this->repository->listPurchaseInvoice($userId);

        foreach ($data as $purchaseInvoice) {
            if ($purchaseInvoice->hasItems()) {
                continue;
            }

            $this->insertItemsInInvoice($purchaseInvoice);
        }
    }

    private function getItems(PurchaseInvoice $purchaseInvoice): array
    {
        $xml = $this->repository->getXml($purchaseInvoice);

        return $this->nfeReader->getPurchaseItems($xml);
    }

    private function insertItemsInInvoice(PurchaseInvoice $purchaseInvoice): void
    {
        $items = $this->getItems($purchaseInvoice);

        foreach ($items as $item) {
            if (empty($item)) {
                continue;
            }

            $this->repository->insertPurchaseItem($purchaseInvoice, $item);
        }
    }
}
