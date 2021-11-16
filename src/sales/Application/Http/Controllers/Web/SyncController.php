<?php

namespace Src\Sales\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $this->syncSales->sync();

        return redirect()->route('sales.list');
    }
}
