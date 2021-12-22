<?php

namespace Src\Costs\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Domain\Repositories\DbRepository;

class PurchaseInvoicesController extends Controller
{
    private DbRepository $repository;

    public function __construct(DbRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listPurchaseInvoices(Request $request)
    {
        $data = $this->repository->listPurchaseInvoice();

        $data = $data->transform(function($model) {
            return [
                'seriesNumber' => "{$model->getSeries()} - {$model->getNumber()}",
                'issuedAt' => $model->getIssuedAt()->format('d/m/Y'),
                'contactName' => $model->getContactName(),
                'value' => 'R$ ' . $model->getValue(),
                'status' => $model->getSituation(),
            ];
        });

        return view('pages.costs.purchase-invoices', [
            'data' => $data->all()
        ]);
    }
}
