<?php

namespace Src\Costs\Domain\UseCases\Contracts;

interface LinkProductToPurchaseItem
{
    public function link(string $itemUuid, string $productSku, string $userId): void;

    public function linkManyProducts(array $data, string $userId): void;
}
