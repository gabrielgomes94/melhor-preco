<?php

namespace Src\Sales\Domain\DataTransfer\Reports;

use Src\Sales\Domain\DataTransfer\ListSalesFilter;

class ListReport
{
    public function __construct(
        public readonly ListMetadata $metadata,
        public readonly ListSalesFilter $filter,
        public readonly array $sales,
        public readonly int $totalSales
    )
    {
    }
}
