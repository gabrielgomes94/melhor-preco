<?php

namespace Src\Sales\Application\UseCases\Reports;

use Src\Sales\Application\Data\Reports\SalesReport;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Domain\Services\Contracts\GetProductSales;

class ReportProductSales
{
    public function __construct(
        private ProductRepository $repository,
        private GetProductSales $getProductSales
    ) {}

    public function report(string $sku): SalesReport
    {
        $product = $this->getProduct($sku);
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

    private function getProduct(string $sku): Product
    {
        $product = $this->repository->get($sku);

        if (!$product) {
            throw new ProductNotFoundException($sku);
        }

        return $product;
    }
}
