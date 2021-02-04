<?php
namespace App\Http\Controllers\Front\Prices;

use App\Bling\Prices\CalculatorService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricesCalculatorController extends Controller
{
    /**
     * @var CalculatorService
     */
    private $calculator;

    public function __construct(CalculatorService $calculator)
    {
        $this->calculator = $calculator;
    }


    public function calculate(Request $request) {
    }

    public function calculate_single(Request $request) {
        $sku = $request->input('sku');
        $price = $request->input('price');

        $price = $this->calculator->calculate($sku, $price);
        dd($price);
    }
}
