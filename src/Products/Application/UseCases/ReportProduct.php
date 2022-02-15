<?php

namespace Src\Products\Application\UseCases;

use Src\Costs\Application\UseCases\ShowProductCosts;
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

    public function get(string $sku): array
    {
        $product = $this->productRepository->get($sku);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $costs = $this->showProductCosts->show($sku);
        $sales = $this->reportProductSales->report($sku);

        return [
            'costs' => $costs,
            'product' => $product,
            'sales' => $sales,
            'redirectLink' => redirect()->back()->getTargetUrl(),
        ];
    }
}
