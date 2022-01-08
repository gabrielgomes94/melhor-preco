<?php

namespace Src\Costs\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Presentation\Presenters\PurchaseInvoicePresenter;
use Src\costs\Domain\Models\PurchaseItem;
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
            abort(404);
        }

        $data = PurchaseInvoicePresenter::present($data);

        return view('pages.Costs.purchase-invoice-details', ['data' => $data]);
    }

    public function listPurchaseInvoices(Request $request)
    {
        $data = $this->repository->listPurchaseInvoice();
        $data = PurchaseInvoicePresenter::presentList($data);

        return view('pages.Costs.purchase-invoices', [
            'data' => $data
        ]);
    }
}
