<?php

namespace Src\Sales\Domain\DataTransfer\Reports\Products;

use Src\Sales\Domain\DataTransfer\SaleItemsCollection;

class ProductReport
{
    public function __construct(
        public readonly ProductSales $productSales,
        public readonly SalesInMarketplaces  $salesInMarketplaces,
        public readonly ?SaleItemsCollection $lastSales = null
    ) {
    }
}
