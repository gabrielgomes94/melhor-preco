<?php

namespace Src\Sales\Domain\Repositories;

use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\Reports\Product\ProductSalesCollection;
use Src\Sales\Domain\DataTransfer\SalesFilter;

interface ReportsRepository
{
//    public function listSales(SalesFilter $options): ListReport;

    public function listMostSelledProducts(SalesFilter $options): ProductSalesCollection;
}
