<?php

namespace Src\Dashboard\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Dashboard\Domain\UseCases\GetSynchronizationInfo;
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
        $data = $this->getSynchronizationInfo->get();

        return view('pages.dashboard', ['data' => $data]);
    }
}
