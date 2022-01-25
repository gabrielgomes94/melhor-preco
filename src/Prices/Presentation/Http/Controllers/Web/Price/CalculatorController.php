<?php

namespace Src\Prices\Presentation\Http\Controllers\Web\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function massCalculation(string $store, Request $request)
    {
        dd($request->all(), $store);
    }
}
