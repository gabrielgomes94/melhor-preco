<?php

namespace App\Http\Controllers\Front\Products\Reports;

use App\Http\Controllers\Controller;
use App\Services\Product\Reports\FilterProducts;
use Illuminate\Http\Request;
use function view;

class DimensionsController extends Controller
{
    private FilterProducts $filterProductsService;

    public function __construct(FilterProducts $filterProductsService)
    {
        $this->filterProductsService = $filterProductsService;
    }

    public function overDimension(Request $request)
    {
        $overDimensionProducts = $this->filterProductsService->getOverDimensions();

        return view('pages.products.reports.over_dimension', [
            'overDimensionProducts' => $overDimensionProducts
        ]);
    }
}
