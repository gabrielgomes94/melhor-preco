<?php

namespace Src\Sales\Domain\Repositories\Reports;

use Src\Sales\Domain\DataTransfer\SalesFilter;

interface ReportMostSelledProducts
{
    public function report(SalesFilter $options, string $userId);
}
