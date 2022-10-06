<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Reports;

use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Src\Sales\Domain\Repositories\ReportsRepository;

class GetProductReport
{
    public function __construct(
        private Repository $costsRepository,
        private ReportsRepository $salesReportsRepository
    ){}

    /**
     * @throws ProductNotFoundException
     */
    public function get(string $sku, string $userId)
    {
        $data = $this->costsRepository->getProductCosts($sku, $userId);

        return new ProductInfoReport(
            costsItems: $data->purchaseItemCosts,
            product: $data->product,
            salesReport: $this->salesReportsRepository->listProductSales(
                $sku,
                new SalesFilter(userId: $userId)
            )
        );
    }
}
