<?php

namespace App\Services\Product\Reports;

use App\Repositories\Product\ListDB;

class FilterProducts
{
    private ListDB $repository;

    public function __construct(ListDB $repository)
    {
        $this->repository = $repository;
    }

    public function getOverDimensions(): array
    {
        $products = $this->repository->all();

        foreach ($products as $product) {
            $dimension = $product->dimensions();

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
