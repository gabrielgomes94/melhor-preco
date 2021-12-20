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

        return view('pages.costs.purchase-invoices', $data->all());
    }
}
