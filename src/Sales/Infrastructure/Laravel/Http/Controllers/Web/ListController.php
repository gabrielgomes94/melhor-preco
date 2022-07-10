<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
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

    public function list(Request $request)
    {
        $options = $this->getFilter($request);
        $listReport = $this->salesReportsRepository->listSales($options);
        $data = $this->listSalesReport->present($listReport);

        return view('pages.sales.list', $data);
    }

    private function getFilter(Request $request)
    {
        return new ListSalesFilter(
            [
                'beginDate' => $request->input('beginDate'),
                'endDate' => $request->input('endDate'),
                'page' => (int) $request->input('page') ?? 1,
                'url' => $request->fullUrlWithQuery($request->query()),
                'userId' => auth()->user()->getAuthIdentifier(),
            ]
        );
    }

    /**
     * @todo: implement show sales view
     */
    public function show()
    {
        dd('asdasdasda');
    }
}
