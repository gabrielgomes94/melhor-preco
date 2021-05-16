<?php

namespace App\Http\Controllers\Front\Pricing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportSpreadsheetController extends Controller
{
    public function __construct()
    {

    }

    public function export(string $id, Request $request)
    {
        dd($request);

    }
}
