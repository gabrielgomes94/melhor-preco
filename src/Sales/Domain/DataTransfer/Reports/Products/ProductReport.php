<?php

namespace Src\Sales\Domain\DataTransfer\Reports\Products;

use Src\Sales\Domain\Models\Collections\SaleItemsCollection;

class ProductReport
{
    public function __construct(
        public readonly SalesInMarketplaces $salesInMarketplaces,
        public readonly ?ProductSales $productSales = null,
        public readonly ?SaleItemsCollection $lastSales = null
    ) {
    }
}
