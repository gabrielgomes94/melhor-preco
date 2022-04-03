<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;

class SyncController extends Controller
{
    public function sync(Request $request)
    {
        SyncCosts::dispatch();

        return redirect()->route('costs.listPurchaseInvoices');
    }
}
