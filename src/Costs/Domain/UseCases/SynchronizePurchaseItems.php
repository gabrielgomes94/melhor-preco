<?php

namespace Src\Costs\Domain\UseCases;

use Illuminate\Support\Collection;
use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Domain\UseCases\Contracts\SyncPurchaseItems;

class SynchronizePurchaseItems implements SyncPurchaseItems
{
    public function __construct(
        private DbRepository $repository,
        private NFeRepository $nfeReader,
    ) {

    }

    public function sync(): void
    {
        $this->execute(
            $this->repository->listPurchaseInvoice()
        );
    }

    private function execute(Collection $data): void
    {
        foreach ($data as $purchaseInvoice) {
            if ($purchaseInvoice->hasItems()) {
                continue;
            }

            $items = $this->getItems($purchaseInvoice);

            foreach ($items as $item) {
                if (empty($item)) {
                    continue;
                }

                $this->repository->insertPurchaseItem($purchaseInvoice, $item);
            }
        }
    }

    private function getItems(PurchaseInvoice $purchaseInvoice): array
    {
        $xml = $this->repository->getXml($purchaseInvoice);

        return $this->nfeReader->getPurchaseItems($xml);
    }
}
