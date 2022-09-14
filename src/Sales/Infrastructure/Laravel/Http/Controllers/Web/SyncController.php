<?php

namespace Src\Sales\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Sales\Infrastructure\Laravel\Jobs\SyncSales as SyncSalesJob;

class SyncController extends Controller
{
    public function __construct()
    {
    }

    public function sync(Request $request)
    {
        SyncSalesJob::dispatch($this->getUserId());

        return redirect()->back();
    }
}
