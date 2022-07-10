<?php

namespace Src\Sales\Domain\DataTransfer\Reports;

use Src\Products\Domain\Models\Product\Product;

class ProductSales
{
    public function __construct(
        public readonly Product $product,
        public readonly float $count,
        public readonly float $averagePrice,
        public readonly float $averageProfit,
        public readonly float $averageMargin,
        public readonly float $totalRevenue,
        public readonly float $totalProfit,
    )
    {
    }
}
