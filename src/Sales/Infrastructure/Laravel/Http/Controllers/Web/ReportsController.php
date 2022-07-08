<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Infrastructure\Laravel\Services\Reports\ReportMostSelledProducts;

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
        $userId = auth()->user()->getAuthIdentifier();

        $data = $this->reportMostSelledProducts->report($options, $userId);

        return view('pages.sales.reports.most-selled-products', ['products' => $data]);
    }
}
