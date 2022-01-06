<?php

namespace Src\Costs\Application\UseCases;

use Illuminate\Support\Collection;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\UseCases\LinkProductToPurchaseItem as LinkProductToPurchaseItemInterface;

class LinkProductToPurchaseItem implements LinkProductToPurchaseItemInterface
{
    private DbRepository $repository;

    public function __construct(DbRepository $repository)
    {
        $this->repository = $repository;
    }

    public function link(string $itemUuid, string $productSku): void
    {
        if (!$item = $this->repository->getPurchaseItem($itemUuid)) {
            return;
        }

        $this->repository->linkItemToProduct($item, $productSku);
    }

    public function linkManyProducts(Collection $data): void
    {
        foreach ($data as $itemUuid => $sku) {
            if (!$sku) {
                continue;
            }

            $this->link($itemUuid, $sku);
        }
    }
}
