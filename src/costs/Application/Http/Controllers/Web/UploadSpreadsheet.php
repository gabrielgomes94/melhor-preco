<?php

namespace Src\Costs\Application\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadSpreadsheet extends Controller
{
    public function show(Request $request)
    {
        return view('pages.costs.upload-spreadsheet');
    }
}
