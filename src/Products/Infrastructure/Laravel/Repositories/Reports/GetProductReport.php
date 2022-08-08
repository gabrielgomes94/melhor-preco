<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Reports;

use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Repositories\ReportsRepository;

class GetProductReport
{
    public function __construct(
        private ShowProductCosts $showProductCosts,
        private ReportsRepository $salesReportsRepository
    ){}

    public function get(string $sku, string $userId)
    {
        $data = $this->showProductCosts->show($sku, $userId);

        return new ProductInfoReport(
            costsItems: collect($data->purchaseItemCosts),
            product: $data->product,
            salesReport: $this->salesReportsRepository->listProductSales(
                $sku,
                new SalesFilter([
                    'page' => 1,
                    'userId' => $userId,
                ])
            )
        );
    }
}