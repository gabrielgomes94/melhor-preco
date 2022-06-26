<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Users\Infrastructure\Laravel\Services\SynchronizeData;

class SynchronizationController extends Controller
{
    private SynchronizeData $synchronizeData;

    public function __construct(SynchronizeData $synchronizeData)
    {
        $this->synchronizeData = $synchronizeData;
    }

    public function sync(Request $request)
    {
        $userId = auth()->user()->id;
        $this->synchronizeData->execute($userId);

        return redirect()->back();
    }
}
