<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Src\Costs\Infrastructure\Laravel\Jobs\SyncCosts;

class SyncController extends Controller
{
    public function sync()
    {
        $userId = auth()->user()->id;
        SyncCosts::dispatch($userId);

        return redirect()->back();
    }
}
