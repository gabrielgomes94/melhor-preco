<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\DataTransfer\Reports\ProductSalesCollection;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\MostSelledProducts;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\SalesList;

class SalesReportsRepository
{
    public function __construct(
        private readonly MostSelledProducts $mostSelledProducts,
        private readonly SalesList $salesList
    )
    {
    }

    public function listSales(ListSalesFilter $options): ListReport
    {
        return $this->salesList->report($options);
    }

    public function listMostSelledProducts(ListSalesFilter $options): ProductSalesCollection
    {
        return $this->mostSelledProducts->report($options);
    }
}
