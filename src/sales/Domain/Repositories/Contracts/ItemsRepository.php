<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;

interface ItemsRepository
{
    public function groupSaleItemsByProduct();

    public function insert(
        SaleOrder $internalSaleOrder,
        Items $items
    ): void;
}
