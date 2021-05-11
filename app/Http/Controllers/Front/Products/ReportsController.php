<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Pricing\Product\FinderDB;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    private FinderDB $repository;

    public function __construct(FinderDB $repository)
    {
        $this->repository = $repository;
    }

    public function overDimension(Request $request)
    {
        $products = $this->repository->all();
        $overDimensionProducts = [];

        foreach ($products as $product) {
            $dimension = $product->dimensions();
            if ($dimension->depth() > 90 ||
                $dimension->width() > 90 ||
                $dimension->height() > 90 ||
                $dimension->sum() > 200
            ) {
                $overDimensionProducts[] = $product;
            }
        }
//        dd($overDimensionProducts);

        return view('products.reports.over_dimension',
            ['overDimensionProducts' => $overDimensionProducts]
        );
    }
}
