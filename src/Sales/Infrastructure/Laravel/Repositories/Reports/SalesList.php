<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Infrastructure\Laravel\Repositories\Queries\SalesQuery;

class SalesList
{
    public function __construct(
        private readonly SalesMetadata $metadataSales
    )
    {
    }

    public function report(ListSalesFilter $options): ListReport
    {
        $metadata = $this->metadataSales->report($options);
        $salesQuery = SalesQuery::salesInInterval($options);

        $sales = $salesQuery->paginate(
            perPage: $options->getPerPage(),
            page: $options->getPage()
        );

        return new ListReport(
            $metadata,
            $options,
            $sales->items(),
            $sales->total()
        );
    }
}
