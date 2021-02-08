<?php
namespace App\Bling\Prices;

use App\Barrigudinha\Prices\Price;

class CalculatorService
{
    private $configs = [
        'taxes' => [
            'IPI' => 0.04, // variar por nota
            'ICMS' => 0.06, // varia entre estados e varia entre produtos importados(14%) e nacional(6%)
            'SimplesNacional' => 0.04, // pra todo mundo, na entrada e na saída
        ],
        'profitMargin' => 0.2,
        'comission' => 0.165,
    ];

    public function calculate(Price $price)
    {
        $costPrice = $price->purchasePrice *
            (1 + $price->taxes['IPI']) *
            (1 + $price->taxes['ICMS']) *
            (1 + $price->taxes['SimplesNacional']);

        $suggestedPrice = $costPrice /
            (1 - $price->commission - $price->taxes['SimplesNacional'] - $price->profitMargin);

        $profit = $this->calculateProfit($suggestedPrice, $costPrice, $price);

        return [
            'salePrices' => [
                'normal' => [
                    'sellingPrice' => $suggestedPrice,
                    'profit' => $profit,
                ],
                '5PercentDiscount' => [
                    'sellingPrice' => $suggestedPrice * 0.95,
                    'profit' => $this->calculateProfit($suggestedPrice * 0.95, $costPrice, $price),
                ]
            ],
        ];
    }

    private function calculateProfit($suggestedPrice, $costPrice, $price)
    {
        $profit = $suggestedPrice - ($costPrice
                + ($suggestedPrice * $price->commission)
                + ($suggestedPrice * $price->taxes['SimplesNacional']));

        return $profit;
    }
}
