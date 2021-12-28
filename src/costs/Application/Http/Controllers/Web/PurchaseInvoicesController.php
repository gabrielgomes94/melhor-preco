<?php

namespace Src\Costs\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\costs\Domain\Models\PurchaseItems;
use Src\Costs\Domain\Repositories\DbRepository;

class PurchaseInvoicesController extends Controller
{
    private DbRepository $repository;

    public function __construct(DbRepository $repository)
    {
        $this->repository = $repository;
    }

    public function showPurchaseInvoices(Request $request, string $uuid)
    {
        $data = $this->repository->getPurchaseInvoice($uuid);

        if (!$data) {
            dd('show error 404');
        }

        $data = [
            'uuid' => $data->getUuid(),
            'series' => $data->getSeries(),
            'seriesNumber' => "{$data->getSeries()} - {$data->getNumber()}",
            'issuedAt' => $data->getIssuedAt()?->format('d/m/Y'),
            'contactName' => $data->getContactName(),
            'number' => $data->getNumber(),
            'situation' => $data->getSituation(),
            'fiscalId' => $data->getFiscalId(),
            'value' => 'R$ ' . $data->getValue(),
            'status' => $data->getSituation(),
            'freightValue' => 0.0,
            'insuranceValue' => 0.0,
            'items' => $data->items->map(function (PurchaseItems $item) {
                return [
                    'name' => $item->name,
                    'purchasePrice' => $item->unit_cost,
                    'additionalCosts' => [
                        'freightValue' => 0.0,
                        'taxesValue' => 0.0,
                        'insuranceValue' => 0.0,
                    ],
                    'unitValue' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'totalValue' => 0.0,
                    'purchaseItemUuid' => $item->uuid,
                    'productSku' => $item->sku ?? '',
                ];
            }),
        ];

        return view('pages.costs.purchase-invoice-details', ['data' => $data]);
    }

    public function listPurchaseInvoices(Request $request)
    {
        $data = $this->repository->listPurchaseInvoice();

        $data = $data->transform(function($model) {
            return [
                'uuid' => $model->getUuid(),
                'series' => $model->getSeries(),
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
