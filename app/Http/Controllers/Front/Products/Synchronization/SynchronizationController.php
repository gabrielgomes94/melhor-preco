<?php

namespace App\Http\Controllers\Front\Products\Synchronization;

use App\Http\Controllers\Controller;
use App\Jobs\SyncProducts;
use Illuminate\Http\Request;
use function view;

class SynchronizationController extends Controller
{
    private SyncProducts $job;

    public function __construct(SyncProducts $job)
    {
        $this->job = $job;
    }

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