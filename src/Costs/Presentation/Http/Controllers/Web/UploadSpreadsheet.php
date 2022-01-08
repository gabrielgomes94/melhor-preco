<?php

namespace Src\Costs\Presentation\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// @deprecated
class UploadSpreadsheet extends Controller
{
    public function show(Request $request)
    {
        return view('pages.Costs.upload-spreadsheet');
    }
}
