<?php

namespace Src\Sales\Infrastructure\Laravel\Repositories;

use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\DataTransfer\Reports\ListReport;
use Src\Sales\Domain\DataTransfer\Reports\Products\ProductSalesCollection;
use Src\Sales\Domain\Reports\ProductSalesReport;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\MostSelledProducts;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\ProductSalesList;
use Src\Sales\Infrastructure\Laravel\Repositories\Reports\SalesList;

/**
 * @deprecated
 */
class SalesReportsRepository
{
    public function __construct(
        private readonly MostSelledProducts $mostSelledProducts,
        private readonly SalesList $salesList,
        private readonly ProductSalesList $productSalesList
    )
    {
    }

    public function listProductSales(string $sku, SalesFilter $options): ProductSalesReport
    {
        return $this->productSalesList->report($sku, $options);
    }

    public function listSales(SalesFilter $options): ListReport
    {
        return $this->salesList->report($options);
    }

    public function listMostSelledProducts(SalesFilter $options): ProductSalesCollection
    {
        return $this->mostSelledProducts->report($options);
    }
}
