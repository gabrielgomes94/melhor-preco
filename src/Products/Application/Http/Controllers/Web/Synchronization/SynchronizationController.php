<?php

namespace Src\Products\Application\Http\Controllers\Web\Synchronization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Application\Jobs\SyncProducts;

class SynchronizationController extends Controller
{
    public function sync(Request $request)
    {
        return view('pages.products.sync.sync');
    }

    public function doSync(Request $request)
    {
        SyncProducts::dispatch();

        return view('pages.products.sync.sync');
    }
}
