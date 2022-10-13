<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\Reports\Product\ProductSalesCollection;
use Src\Sales\Domain\Repositories\ReportsRepository as ReportsRepositoryInterface;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\MostSelledProducts;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\SalesList;

class ReportsRepository implements ReportsRepositoryInterface
{
    public function __construct(
        private readonly MostSelledProducts $mostSelledProducts,
        private readonly SalesList $salesList,
//        private readonly ProductSalesList $productSalesList
    ) {
    }

//    public function listProductSales(string $sku, SalesFilter $options): ProductReport
//    {
//        return $this->productSalesList->report($sku, $options);
//    }

    public function listSales(SalesFilter $options): ListReport
    {
        return $this->salesList->report($options);
    }

    public function listMostSelledProducts(SalesFilter $options): ProductSalesCollection
    {
        return $this->mostSelledProducts->report($options);
    }
}
