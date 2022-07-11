<?php

namespace Src\Sales\Domain\Repositories;

use Carbon\Carbon;
use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Domain\Models\SaleOrder;
use Src\Sales\Domain\Models\ValueObjects\Items\Items;
use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

interface SaleItemsRepository
{
    public function countSalesByProduct(Product $product, Carbon $beginDate, Carbon $endDate): int;

    public function groupSaleItemsByProduct(ListSalesFilter $options);
}
