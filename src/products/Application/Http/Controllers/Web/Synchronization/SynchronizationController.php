<?php

namespace Src\Products\Application\Http\Controllers\Web\Synchronization;

use App\Http\Controllers\Controller;
use Src\Products\Application\Jobs\SyncProducts;
use Illuminate\Http\Request;
use Src\Notifications\Domain\Notifications\Products\ProductsSynchronized;

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
