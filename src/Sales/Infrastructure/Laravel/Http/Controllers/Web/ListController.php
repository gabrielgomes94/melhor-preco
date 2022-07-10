<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Infrastructure\Laravel\Http\Requests\SalesReportsRequest;
use Src\Sales\Infrastructure\Laravel\Presenters\ListSalesReport;
use Src\Sales\Infrastructure\Laravel\Repositories\SalesReportsRepository;

class ListController extends Controller
{
    public function __construct(
        private readonly SalesReportsRepository $salesReportsRepository,
        private readonly ListSalesReport $listSalesReport
    )
    {
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
