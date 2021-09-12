<?php

namespace App\Http\Controllers\Front\Sales;

use App\Exports\Sales\SaleOrderExport;
use App\Http\Controllers\Controller;
use App\Services\Sales\Service;
use Integrations\Bling\Base\Responses\ErrorResponse;
use Integrations\Bling\SaleOrders\Repository;
use Maatwebsite\Excel\Facades\Excel;

class ListController extends Controller
{
    private Service $service;
    private Repository $repository;

    public function __construct(Service $service, Repository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function list()
    {
        $response = $this->repository->list();

        if ($response instanceof ErrorResponse) {
            abort(404);
        }

        $saleOrders = $this->service->listSaleOrder($response->data());

        return view('pages.sales.list', [
            'saleOrders' => $saleOrders['saleOrders'],
            'total' => $saleOrders['total'],
        ]);
    }

    public function export()
    {
        $response = $this->repository->list();

        if ($response instanceof ErrorResponse) {
            abort(404);
        }

        $saleOrders = $this->service->listSaleOrder($response->data());

        return Excel::download(new SaleOrderExport($saleOrders), 'sales.xlsx');
    }
}
