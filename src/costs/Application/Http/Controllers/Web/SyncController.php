<?php

namespace Src\Costs\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Application\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Application\UseCases\SynchronizePurchaseItems;

class SyncController extends Controller
{
    private SynchronizePurchaseInvoices $syncPurchaseInvoices;
    private SynchronizePurchaseItems $syncPurchaseItems;

    public function __construct(
        SynchronizePurchaseInvoices $syncPurchaseInvoices,
        SynchronizePurchaseItems $syncPurchaseItems
    ) {
        $this->syncPurchaseInvoices = $syncPurchaseInvoices;
        $this->syncPurchaseItems = $syncPurchaseItems;
    }

    public function sync(Request $request)
    {
        $this->syncPurchaseInvoices->sync();
        $this->syncPurchaseItems->sync();
    }
}
