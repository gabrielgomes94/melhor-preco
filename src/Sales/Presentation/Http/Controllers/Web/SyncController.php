<?php

namespace Src\Sales\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Sales\Application\Jobs\SyncSales as SyncSalesJob;
use Src\Sales\Application\UseCases\SyncSales;

class SyncController extends Controller
{
    private SyncSales $syncSales;

    public function __construct(SyncSales $syncSales)
    {
        $this->syncSales = $syncSales;
    }

    public function sync(Request $request)
    {
        $userId = auth()->user()->getAuthIdentifier();
        SyncSalesJob::dispatch($userId);

        return redirect()->back();
    }
}
