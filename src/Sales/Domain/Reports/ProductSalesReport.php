<?php

namespace Src\Sales\Domain\Reports;

use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Domain\DataTransfer\SaleItemsCollection;

// @deprecated
class ProductSalesReport
{
    public function __construct(
        private readonly Product $product,
        private readonly SaleItemsCollection $saleItemsCollection,
    )
    {
    }
}
