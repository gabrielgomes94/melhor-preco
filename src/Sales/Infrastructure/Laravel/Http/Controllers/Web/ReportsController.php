<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Sales\Domain\DataTransfer\ListSalesFilter;
use Src\Sales\Infrastructure\Laravel\Presenters\ProductSalesPresenter;
use Src\Sales\Infrastructure\Laravel\Repositories\SalesReportsRepository;

class ReportsController extends Controller
{
    public function __construct(
        private readonly SalesReportsRepository $salesReportsRepository,
        private readonly ProductSalesPresenter $presenter
    )
    {
    }

    public function mostSelledProducts(Request $request)
    {
        $options = new ListSalesFilter(
            [
                'beginDate' => $request->input('beginDate'),
                'endDate' => $request->input('endDate'),
                'page' => (int) $request->input('page') ?? 1,
                'userId' => auth()->user()->getAuthIdentifier(),
            ]
        );

        $mostSelledProducts = $this->salesReportsRepository->listMostSelledProducts($options);
        $data = $this->presenter->present($mostSelledProducts);

        return view('pages.sales.reports.most-selled-products', ['products' => $data]);
    }
}
