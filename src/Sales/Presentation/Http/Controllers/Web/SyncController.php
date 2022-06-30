<?php

namespace Src\Sales\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Sales\Application\Jobs\SyncSales as SyncSalesJob;

class SyncController extends Controller
{
    public function __construct()
    {
    }

    public function sync(Request $request)
    {
        $userId = auth()->user()->getAuthIdentifier();
        SyncSalesJob::dispatch($userId);

        return redirect()->back();
    }
}
