<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories\Reports;

use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Src\Sales\Application\Repositories\Queries\SalesQuery;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\Factories\SalesMetadataFactory;

/**
 * @deprecated
 */
class SalesList
{
    public function __construct(
        private readonly SalesMetadataFactory $metadataSales
    ) {
    }

    public function report(SalesFilter $options): ListReport
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
            new SaleOrdersCollection($sales->items()),
            $sales->total()
        );
    }
}
