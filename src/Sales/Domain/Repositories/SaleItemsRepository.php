<?php

namespace Src\Sales\Domain\Repositories;

use Carbon\Carbon;
use Src\Products\Domain\Models\Product;
use Src\Sales\Domain\DataTransfer\SalesFilter;

interface SaleItemsRepository
{
    public function countSalesByProduct(Product $product, Carbon $beginDate, Carbon $endDate): int;

    public function groupSaleItemsByProduct(SalesFilter $options);
}
