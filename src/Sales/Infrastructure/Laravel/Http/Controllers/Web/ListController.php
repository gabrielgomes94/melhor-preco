<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Sales\Domain\Repositories\ReportsRepository;
use Src\Sales\Infrastructure\Laravel\Http\Requests\SalesReportsRequest;
use Src\Sales\Infrastructure\Laravel\Presenters\SalesList\SalesReport;

class ListController extends Controller
{
    public function __construct(
        private readonly ReportsRepository $salesReportsRepository,
        private readonly SalesReport $listSalesReport
    ) {
    }

    public function list(SalesReportsRequest $request)
    {
        $listReport = $this->salesReportsRepository->listSales(
            $request->transform()
        );
        $data = $this->listSalesReport->present($listReport);

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
