<?php

namespace Src\Costs\Domain\UseCases;

use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\UseCases\Contracts\LinkProductToPurchaseItem as LinkProductToPurchaseItemInterface;

class LinkProductToPurchaseItem implements LinkProductToPurchaseItemInterface
{
    public function __construct(
        private DbRepository $repository
    )
    {}

    public function link(string $itemUuid, string $productSku, string $userId): void
    {
        if (!$item = $this->repository->getPurchaseItem($userId, $itemUuid)) {
            return;
        }

        $this->repository->linkItemToProduct($item, $productSku);
    }

    public function linkManyProducts(array $data, string $userId): void
    {
        foreach ($data as $itemUuid => $sku) {
            if (!$sku) {
                continue;
            }

            $this->link($itemUuid, $sku, $userId);
        }
    }
}
