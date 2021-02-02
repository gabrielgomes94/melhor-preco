<?php
namespace App\Http\Controllers\Front\Prices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricesCalculatorController extends Controller
{
    public function calculate(Request $request) {
    }

    public function calculate_single(Request $request) {
        $sku = $request->input('sku');
        $price = $request->input('price');

        dd($price);
    }
}
