<?php

namespace Src\Products\Application\Data\Reports;

use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Contracts\Product;
use Src\Sales\Application\Data\Reports\SalesReport;

class ProductInfoReport
{
    public function __construct(
        public readonly Collection $costsItems,
        public readonly Product $product,
        public readonly SalesReport $salesReport
    )
    {}
}
