<?php

namespace Src\Sales\Domain\UseCases\Contracts\Reports;

use Src\Sales\Domain\UseCases\Contracts\Filters\ListSalesFilter;

interface ReportMostSelledProducts
{
    public function report(ListSalesFilter $options, string $userId);
}
