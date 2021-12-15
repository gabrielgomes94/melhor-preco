<?php

namespace Src\Sales\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Sales\Application\UseCases\Filters\ListSalesFilter;
use Src\Sales\Application\UseCases\Reports\ReportMostSelledProducts;

class ReportsController extends Controller
{
    private ReportMostSelledProducts $reportMostSelledProducts;

    public function __construct(ReportMostSelledProducts $reportMostSelledProducts)
    {
        $this->reportMostSelledProducts = $reportMostSelledProducts;
    }

    public function mostSelledProducts(Request $request)
    {
        $options = new ListSalesFilter(
            [
                'beginDate' => $request->input('beginDate'),
                'endDate' => $request->input('endDate'),
                'page' => $page = (int) $request->input('page') ?? 1,
            ]
        );

        $data = $this->reportMostSelledProducts->report($options);

        return view('pages.sales.reports.most-selled-products', ['products' => $data]);
    }
}
