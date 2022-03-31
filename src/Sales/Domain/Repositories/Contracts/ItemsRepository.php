<?php

namespace Src\Sales\Domain\Repositories\Contracts;

use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

interface ItemsRepository
{
    public function countSalesByProduct(Product $product, ListSalesFilter $options): int;

    public function groupSaleItemsByProduct(ListSalesFilter $options);

    public function insert(
        SaleOrder $internalSaleOrder,
        Items $items
    ): void;
}
