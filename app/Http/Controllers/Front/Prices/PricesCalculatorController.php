<?php
namespace App\Http\Controllers\Front\Prices;

use App\Barrigudinha\Prices\Price;
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

    public function calculate_single(Request $request)
    {
        $data = [
            'sku' => $request->input('sku'),
            'purchasePrice' => $request->input('price'),
            'taxes' => [
                'IPI' => $request->input('tax-ipi') / 100.0,
                'ICMSDifference' => $request->input('tax-icms') / 100.0,
                'SimplesNacional' => 4 / 100.0,

            ],
            'commission' => $request->input('commission') / 100.0,
            'profitMargin' => $request->input('profit-margin') / 100.0,
            'freight' => $request->input('freight'),
            'sellingPrice' => $request->input('selling-price')
        ];

        $price = new Price($data);
        $salePrices = $this->calculator->calculate($price);

        return view('prices.single', [
            'salePrices' => $salePrices,
            'purchasePrice' => $request->input('price'),
            'priceParams' => $request->all(),
        ]);
    }
}
