<?php

namespace Src\Sales\Application\UseCases\Reports;

use Src\Sales\Application\Data\Reports\SalesReport;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Sales\Domain\Services\Contracts\GetProductSales;

class ReportProductSales
{
    public function __construct(
        private ProductRepository $repository,
        private GetProductSales $getProductSales
    ) {
    }

    public function report(string $sku, string $userId): SalesReport
    {
        $product = $this->getProduct($sku, $userId);
        $salesInMarketplaces = $this->getProductSales->getSaleItemsInAllMarketplaces($product);
        $lastSales = $this->getProductSales->getLastSaleItems($product);
        $totalItemsSelled = $this->getProductSales->getTotalSaleItems($product);

        $salesReport = new SalesReport(
            product: $product,
            salesInMarketplaces: $salesInMarketplaces,
            itemsSelled: $totalItemsSelled,
            lastSales: $lastSales,
        );

        return $salesReport;
    }

    private function getProduct(string $sku, string $userId): Product
    {
        $product = $this->repository->get($sku, $userId);

        if (!$product) {
            throw new ProductNotFoundException($sku);
        }

        return $product;
    }
}
