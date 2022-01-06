<?php

namespace Src\Costs\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Application\Jobs\SyncCosts;
use Src\Costs\Application\UseCases\SynchronizePurchaseInvoices;
use Src\Costs\Application\UseCases\SynchronizePurchaseItems;

class SyncController extends Controller
{
    public function sync(Request $request)
    {
        SyncCosts::dispatch();

        return redirect()->route('costs.listPurchaseInvoices');
    }
}
