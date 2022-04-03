<?php

namespace Src\Costs\Domain\UseCases;

use Illuminate\Support\Collection;
use Src\Costs\Infrastructure\Laravel\Repositories\Mappers\PurchaseItemTransformer;
use Src\Costs\Domain\Models\Contracts\PurchaseInvoice;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\Repositories\NFeRepository;
use Src\Costs\Domain\UseCases\Contracts\SyncPurchaseItems;

class SynchronizePurchaseItems implements SyncPurchaseItems
{
    private DbRepository $repository;
    private NFeRepository $nfeReader;
    private PurchaseItemTransformer $purchaseItemTransformer;

    public function __construct(
        DbRepository $repository,
        NFeRepository $nfeReader,
        PurchaseItemTransformer $purchaseItemTransformer
    ) {
        $this->repository = $repository;
        $this->nfeReader = $nfeReader;
        $this->purchaseItemTransformer = $purchaseItemTransformer;
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

            $this->insertItems($purchaseInvoice, $this->getItems($purchaseInvoice));
        }
    }

    private function getItems(PurchaseInvoice $purchaseInvoice): array
    {
        $xml = $this->repository->getXml($purchaseInvoice);

        return $this->nfeReader->getItems($xml);
    }

    private function insertItems(PurchaseInvoice $purchaseInvoice, array $items): void
    {
        foreach ($items as $item) {
            if (empty($item)) {
                continue;
            }

            $item = $this->purchaseItemTransformer->transform($item);
            $this->repository->insertPurchaseItem($purchaseInvoice, $item);
        }
    }
}
