<?php

namespace Src\Costs\Domain\UseCases\Contracts;

use Illuminate\Support\Collection;

interface LinkProductToPurchaseItem
{
    public function link(string $itemUuid, string $productSku): void;

    public function linkManyProducts(array $data): void;
}
