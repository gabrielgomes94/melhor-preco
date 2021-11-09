<?php

namespace Src\Sales\Application\Http\Controllers\Web;

use Illuminate\Http\Request;
use Src\Sales\Application\Exports\SaleOrderExport;
use App\Http\Controllers\Controller;
use Src\Integrations\Bling\Base\Responses\ErrorResponse;
use Maatwebsite\Excel\Facades\Excel;
use Src\Sales\Domain\Contracts\UseCases\ListSales;

class ListController extends Controller
{
    private ListSales $listSales;

    public function __construct(ListSales $listSales)
    {
        $this->listSales = $listSales;
    }

    public function list(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $saleOrders = $this->listSales->list($page);

        return view('pages.sales.list', [
            'saleOrders' => $saleOrders['saleOrders'],
            'total' => $saleOrders['total'],
            'paginator' => $saleOrders['paginator'],
        ]);
    }

//    public function export()
//    {
//        $response = $this->repository->list();
//
//        if ($response instanceof ErrorResponse) {
//            abort(404);
//        }
//
//        $saleOrders = $this->service->listSaleOrder($response->data());
//
//        return Excel::download(new SaleOrderExport($saleOrders), 'sales.xlsx');
//    }
}
