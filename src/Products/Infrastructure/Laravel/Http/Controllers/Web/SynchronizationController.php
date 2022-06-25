<?php

namespace Src\Products\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Products\Infrastructure\Laravel\Jobs\SyncCategories;
use Src\Products\Infrastructure\Laravel\Jobs\SyncProducts;

class SynchronizationController extends Controller
{
    public function sync(Request $request)
    {
        return view('pages.products.sync.sync');
    }

    public function doSync()
    {
        SyncProducts::dispatch((auth()->user()));

        return redirect()->back();
    }

    public function doSyncCategory()
    {
        SyncCategories::dispatch(auth()->user());

        return redirect()->back();
    }
}