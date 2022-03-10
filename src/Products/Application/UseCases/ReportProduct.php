<?php

namespace Src\Products\Application\UseCases;

use Src\Costs\Application\UseCases\ShowProductCosts;
use Src\Products\Application\Data\Reports\ProductInfoReport;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Src\Sales\Application\UseCases\Reports\ReportProductSales;

class ReportProduct
{
    public function __construct(
        private ProductRepository $productRepository,
        private ShowProductCosts   $showProductCosts,
        private ReportProductSales $reportProductSales
    ){}

    public function get(string $sku): ProductInfoReport
    {
        $product = $this->productRepository->get($sku);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        return new ProductInfoReport(
            costsItems: $this->showProductCosts->show($sku),
            product: $product,
            salesReport: $this->reportProductSales->report($sku)
        );
    }
}
