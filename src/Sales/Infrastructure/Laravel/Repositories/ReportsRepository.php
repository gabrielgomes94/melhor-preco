<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\Reports\Product\ProductSalesCollection;
use Src\Sales\Domain\Repositories\ReportsRepository as ReportsRepositoryInterface;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\MostSelledProducts;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\SalesList;

/**
 * @deprecated
 */
class ReportsRepository implements ReportsRepositoryInterface
{
    public function __construct(
        private readonly MostSelledProducts $mostSelledProducts,
//        private readonly SalesList $salesList,
    ) {
    }

//    public function listSales(SalesFilter $options): ListReport
//    {
//        return $this->salesList->report($options);
//    }

    public function listMostSelledProducts(SalesFilter $options): ProductSalesCollection
    {
        return $this->mostSelledProducts->report($options);
    }
}
