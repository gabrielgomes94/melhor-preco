<?php

namespace Src\Products\Application\Http\Controllers\Web\Synchronization;

use App\Http\Controllers\Controller;
use Src\Products\Application\Jobs\SyncProducts;
use Illuminate\Http\Request;
use Src\Notifications\Domain\Notifications\Products\ProductsSynchronized;

use Src\Products\Application\UseCases\SynchronizeProducts;
use function view;

class SynchronizationController extends Controller
{
    private SynchronizeProducts $synchronizeProducts;

    public function __construct(SynchronizeProducts $synchronizeProducts)
    {
        $this->synchronizeProducts = $synchronizeProducts;
    }

    public function sync(Request $request)
    {
        return view('pages.products.sync.sync');
    }

    public function doSync(Request $request)
    {
        $this->synchronizeProducts->sync();

        return view('pages.products.sync.sync');
    }
}
