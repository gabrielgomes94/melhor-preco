<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

interface ItemsRepository
{
    public function groupSaleItemsByProduct(ListSalesFilter $options);

    public function insert(
        SaleOrder $internalSaleOrder,
        Items $items
    ): void;
}
