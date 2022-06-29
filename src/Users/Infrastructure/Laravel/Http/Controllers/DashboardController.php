<?php

namespace Src\Users\Infrastructure\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Users\Domain\UseCases\GetSynchronizationInfo;
use function view;

class DashboardController extends Controller
{
    private GetSynchronizationInfo $getSynchronizationInfo;

    public function __construct(GetSynchronizationInfo $getSynchronizationInfo)
    {
        $this->getSynchronizationInfo = $getSynchronizationInfo;
    }

    public function index(Request $request)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $data = $this->getSynchronizationInfo->get($userId);

        return view('pages.dashboard', ['data' => $data]);
    }
}
