<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ListDB;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    private ListDB $repository;

    public function __construct(ListDB $repository)
    {
        $this->repository = $repository;
    }

    public function overDimension(Request $request)
    {
        $products = $this->repository->all();
        $overDimensionProducts = [];

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
//        dd($overDimensionProducts);

        return view(
            'pages.products.reports.over_dimension',
            ['overDimensionProducts' => $overDimensionProducts]
        );
    }
}
