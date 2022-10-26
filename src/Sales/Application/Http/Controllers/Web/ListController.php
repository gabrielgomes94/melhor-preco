<?php

namespace Src\Sales\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Sales\Application\Reports\Factories\SalesReport;
use Src\Sales\Application\Http\Requests\SalesReportsRequest;
use Src\Sales\Application\Presenters\SalesList\SalesReportPresenter;

class ListController extends Controller
{
    public function __construct(
        private readonly SalesReport $salesReport,
        private readonly SalesReportPresenter $listSalesReport
    ) {
    }

    public function list(SalesReportsRequest $request)
    {
        $listReport = $this->salesReport->report($request->transform());
        $data = $this->listSalesReport->present($listReport, $request->transform());

        return view('pages.sales.list', $data);
    }

    /**
     * @todo: implement show sales view
     */
    public function show()
    {
        dd('asdasdasda');
    }
}
