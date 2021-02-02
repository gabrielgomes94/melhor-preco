<?php
namespace App\Http\Controllers\Front\Prices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function single() {
        return view('prices.single');
    }

    public function import() {
        return view();
    }
}
