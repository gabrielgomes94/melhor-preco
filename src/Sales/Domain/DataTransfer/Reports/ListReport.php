<?php

namespace Src\Sales\Domain\DataTransfer\Reports;

use Src\Sales\Domain\DataTransfer\SalesFilter;

class ListReport
{
    public function __construct(
        public readonly ListMetadata $metadata,
        public readonly SalesFilter  $filter,
        public readonly array        $sales,
        public readonly int          $totalSales
    )
    {
    }
}
