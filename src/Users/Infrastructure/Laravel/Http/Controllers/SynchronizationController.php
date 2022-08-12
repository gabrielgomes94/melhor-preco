<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Users\Domain\Services\SynchronizeData;

class SynchronizationController extends Controller
{
    public function __construct(
        private readonly SynchronizeData $synchronizeData
    )
    {}

    public function sync(Request $request)
    {
        $userId = auth()->user()->id;
        $this->synchronizeData->execute($userId);

        return redirect()->back();
    }
}
