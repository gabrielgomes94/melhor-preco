<?php

namespace Src\Products\Application\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Src\Products\Application\Services\Reports\FilterProducts;
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
