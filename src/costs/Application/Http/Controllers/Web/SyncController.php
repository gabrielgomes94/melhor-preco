<?php

namespace Src\Costs\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Application\UseCases\SynchronizePurchaseInvoices;

class SyncController extends Controller
{
    private SynchronizePurchaseInvoices $syncPurchaseInvoices;

    public function __construct(SynchronizePurchaseInvoices $syncPurchaseInvoices)
    {
        $this->syncPurchaseInvoices = $syncPurchaseInvoices;
    }

    public function sync(Request $request)
    {
        $this->syncPurchaseInvoices->sync();
    }
}
