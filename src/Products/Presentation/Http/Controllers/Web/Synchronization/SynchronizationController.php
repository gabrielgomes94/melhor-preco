<?php

namespace Src\Products\Presentation\Http\Controllers\Web\Synchronization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Application\Jobs\SyncCategories;
use Src\Products\Application\Jobs\SyncProducts;

class SynchronizationController extends Controller
{
    public function sync(Request $request)
    {
        return view('pages.products.sync.sync');
    }

    public function doSync(Request $request)
    {
        $userId = auth()->user()->id;
        SyncCategories::dispatch($userId);
        SyncProducts::dispatch($userId);

        return view('pages.products.sync.sync');
    }
}
