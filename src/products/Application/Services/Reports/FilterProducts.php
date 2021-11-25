<?php

namespace Src\Products\Application\Services\Reports;

use Src\Products\Application\Services\ListProducts;

class FilterProducts
{
    private ListProducts $listProductsService;

    public function __construct(ListProducts $listProductsService)
    {
        $this->listProductsService = $listProductsService;
    }

    public function getOverDimensions(): array
    {
        $products = $this->listProductsService->all();

        foreach ($products as $product) {
            $dimension = $product->getDimensions();

            if (
                $dimension->depth() > 90 ||
                $dimension->width() > 90 ||
                $dimension->height() > 90 ||
                $dimension->sum() > 200
            ) {
                $overDimensionProducts[] = $product;
            }
        }

        return $overDimensionProducts ?? [];
    }
}
