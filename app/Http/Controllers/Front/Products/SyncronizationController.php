<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Jobs\SyncProducts;
use Illuminate\Http\Request;

class SyncronizationController extends Controller
{
    private SyncProducts $job;

    public function __construct(SyncProducts $job)
    {
        $this->job = $job;
    }

    public function sync(Request $request)
    {
        return view('products.sync.sync');
    }

    public function doSync(Request $request)
    {
        $this->job->dispatch();

        return view('products.sync.sync');
    }
}
