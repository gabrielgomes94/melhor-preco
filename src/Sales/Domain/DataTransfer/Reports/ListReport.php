<?php

namespace Src\Sales\Domain\DataTransfer\Reports;

use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;

class ListReport
{
    public function __construct(
        public readonly ListMetadata $metadata,
        public readonly SalesFilter $filter,
        public readonly SaleOrdersCollection $sales,
        public readonly int $totalSales
    ) {
    }
}
