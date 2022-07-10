<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Infrastructure\Laravel\Repositories\SalesReportsRepository;

class GetProductReport
{
    public function __construct(
        private ShowProductCosts   $showProductCosts,
        private SalesReportsRepository $salesReportsRepository
    ){}

    public function get(string $sku, string $userId)
    {
        $data = $this->showProductCosts->show($sku, $userId);

        return new ProductInfoReport(
            costsItems: $data['costs'],
            product: $data['product'],
            salesReport: $this->salesReportsRepository->listProductSales(
                $sku,
                new ListSalesFilter([
                    'page' => 1,
                    'userId' => $userId,
                ])
            )
        );
    }
}
