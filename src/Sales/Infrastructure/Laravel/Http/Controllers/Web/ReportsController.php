<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Sales\Infrastructure\Laravel\Http\Requests\SalesReportsRequest;
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

    public function mostSelledProducts(SalesReportsRequest $request)
    {
        $mostSelledProducts = $this->salesReportsRepository->listMostSelledProducts(
            $request->transform()
        );
        $data = $this->presenter->present($mostSelledProducts);

        return view(
            'pages.sales.reports.most-selled-products',
            ['products' => $data]
        );
    }
}
