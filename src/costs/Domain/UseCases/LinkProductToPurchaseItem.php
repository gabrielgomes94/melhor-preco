<?php

namespace Src\Costs\Domain\UseCases;

interface LinkProductToPurchaseItem
{
    public function link(string $itemUuid, string $productSku): bool;
}
