<?php

namespace Src\Sales\Domain\Repositories;

use Carbon\Carbon;
use Src\Products\Domain\Models\Product;

interface ProductSalesRepository
{
    public function count(
        Product $product,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): int;

    public function getItemsSelled(
        Product $product,
        ?Carbon $beginDate = null,
        ?Carbon $endDate = null
    ): array;
}
