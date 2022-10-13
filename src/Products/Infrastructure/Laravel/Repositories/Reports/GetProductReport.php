<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Reports;

use Src\Costs\Infrastructure\Laravel\Repositories\Repository;
use Src\Products\Domain\DataTransfer\ProductInfoReport;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Sales\Application\Reports\Factories\ProductSalesInMarketplaceReport;
use Src\Sales\Application\Reports\Factories\ProductSalesReport;

class GetProductReport
{
    public function __construct(
        private Repository $costsRepository,
        private ProductSalesReport $productSalesReport,
        private ProductSalesInMarketplaceReport $productSalesInMarketplaceReport,
    ){}

    /**
     * @throws ProductNotFoundException
     */
    public function get(string $sku, string $userId)
    {
        $data = $this->costsRepository->getProductCosts($sku, $userId);
        $salesReport = $this->productSalesReport->report($sku, $userId);
        $marketplaceSales = $this->productSalesInMarketplaceReport->report($sku, $userId);

        return new ProductInfoReport(
            costsItems: $data->purchaseItemCosts,
            product: $data->product,
            productSales: $salesReport,
            marketplaceSales: $marketplaceSales
        );
    }
}
