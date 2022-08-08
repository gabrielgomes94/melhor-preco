<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseInvoicePresenter;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Costs\Domain\Repositories\DbRepository;

class PurchaseInvoicesController extends Controller
{
    public function __construct(
        private DbRepository $repository,
        private PurchaseInvoicePresenter $purchaseInvoicePresenter
    ) {}

    /**
     * @todo Criar exception para erro de PurchaseInvoice
     */
    public function showPurchaseInvoices(string $uuid)
    {
        $data = $this->repository->getPurchaseInvoice($uuid);

        if (!$data) {
            abort(404);
        }

        $data = $this->purchaseInvoicePresenter->present($data);

        return view('pages.costs.invoices.show', ['data' => $data]);
    }

    public function listPurchaseInvoices()
    {
        $data = $this->repository->listPurchaseInvoice();
        $data = $this->purchaseInvoicePresenter->presentList($data);

        return view('pages.costs.invoices.list', [
            'data' => $data
        ]);
    }
}
