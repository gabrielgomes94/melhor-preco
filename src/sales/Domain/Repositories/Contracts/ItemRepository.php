<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;

interface ItemRepository
{
    public static function groupSaleItemsByProduct();

    public static function insert(
        SaleOrder $internalSaleOrder,
        Items $items
    ): void;
}
