<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Application\UseCases\Reports\ReportProductSales;

class GetProductReport
{
    public function __construct(
        private ProductRepository $productRepository,
        private ShowProductCosts   $showProductCosts,
        private ReportProductSales $reportProductSales
    ){}

    public function get(string $sku)
    {
        $data = $this->showProductCosts->show($sku);

        return new ProductInfoReport(
            costsItems: $data['costs'],
            product: $data['product'],
            salesReport: $this->reportProductSales->report($sku)
        );
    }
}
