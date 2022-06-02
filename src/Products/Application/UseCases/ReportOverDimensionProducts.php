<?php

namespace Src\Products\Application\UseCases;

use Src\Products\Application\Services\ListProducts;
use Src\Products\Domain\UseCases\Contracts\ReportOverDimensionsProducts as ReportOverDimensionsProductsInterface;

// @deprecated
class ReportOverDimensionProducts implements ReportOverDimensionsProductsInterface
{
    private ListProducts $listProductsService;

    public function __construct(ListProducts $listProductsService)
    {
        $this->listProductsService = $listProductsService;
    }

    public function getOverDimensions(float $depth, float $width, float $height, float $cubicWeight): array
    {
        $products = $this->listProductsService->all();

        foreach ($products as $product) {
            $dimension = $product->getDimensions();

            if (
                $dimension->depth() > $depth ||
                $dimension->width() > $width ||
                $dimension->height() > $height ||
                $dimension->sum() > $cubicWeight
            ) {
                $overDimensionProducts[] = $product;
            }
        }

        return [
            'overDimensionProducts' => $overDimensionProducts ?? []
        ];
    }
}
