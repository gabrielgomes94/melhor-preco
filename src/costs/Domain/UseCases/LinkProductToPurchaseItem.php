<?php

namespace Src\Costs\Domain\UseCases;

use Illuminate\Support\Collection;

interface LinkProductToPurchaseItem
{
    public function link(string $itemUuid, string $productSku): void;

    public function linkManyProducts(Collection $data): void;
}
