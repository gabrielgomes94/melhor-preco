<?php

namespace Src\Sales\Application\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Src\Sales\Domain\UseCases\Contracts\ListSales;

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
            'total' => $saleOrders['meta'],
            'paginator' => $saleOrders['paginator'],
        ]);
    }
}
