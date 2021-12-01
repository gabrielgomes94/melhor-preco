<?php

namespace Src\Products\Application\Http\Controllers\Web\Reports;

use App\Http\Controllers\Controller;
use Src\Products\Application\UseCases\ReportOverDimensionProducts;
use Illuminate\Http\Request;

use function view;

class DimensionsController extends Controller
{
    private ReportOverDimensionProducts $filterProductsService;

    public function __construct(ReportOverDimensionProducts $filterProductsService)
    {
        $this->filterProductsService = $filterProductsService;
    }

    public function overDimension(Request $request)
    {
        $data = $this->filterProductsService
            ->getOverDimensions(90, 90, 90, 200);

        return view('pages.products.reports.over_dimension', $data);
    }
}
