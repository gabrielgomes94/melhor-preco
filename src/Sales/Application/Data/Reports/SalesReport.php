<?php

namespace Src\Sales\Application\Data\Reports;

use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Application\Data\SaleItemsCollection;

class SalesReport
{
    public function __construct(
        public readonly Product $product,
        public readonly SaleItemsInMarketplaces $salesInMarketplaces,
        public readonly SaleItemsCollection $itemsSelled,
        public readonly SaleItemsCollection $lastSales
    ) {
    }
}
