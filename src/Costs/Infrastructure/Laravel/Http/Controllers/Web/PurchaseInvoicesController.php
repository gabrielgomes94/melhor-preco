<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Src\Costs\Domain\Exceptions\PurchaseInvoiceNotFoundException;
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
        try {
            $data = $this->repository->getPurchaseInvoice($this->getUserId(), $uuid);
        } catch (QueryException $exception) {
            throw new PurchaseInvoiceNotFoundException($uuid);
        }

        if (!$data) {
            throw new PurchaseInvoiceNotFoundException($uuid);
        }

        $data = $this->purchaseInvoicePresenter->present($data);

        return view('pages.costs.invoices.show', ['data' => $data]);
    }

    public function listPurchaseInvoices(): View|Factory
    {
        $data = $this->repository->listPurchaseInvoice($this->getUserId());
        $data = $this->purchaseInvoicePresenter->presentList($data);

        return view('pages.costs.invoices.list', [
            'data' => $data
        ]);
    }
}
