<?php

namespace Src\Sales\Presentation\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Src\Sales\Application\UseCases\Filters\ListSalesFilter;
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
        $options = new ListSalesFilter(
            [
                'beginDate' => $request->input('beginDate'),
                'endDate' => $request->input('endDate'),
                'page' => $page = (int) $request->input('page') ?? 1,
            ]
        );

        $saleOrders = $this->listSales->list($options);

        return view('pages.sales.list', [
            'saleOrders' => $saleOrders['saleOrders'],
            'total' => $saleOrders['meta'],
            'paginator' => $saleOrders['paginator'],
        ]);
    }
}
