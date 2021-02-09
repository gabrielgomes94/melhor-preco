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
                    'sellingPrice' => round($suggestedPrice, 2),
                    'costPrice' => round($costPrice),
                    'commission' => round($suggestedPrice * $price->commission),
                    'profit' => round($profit, 2),
                ],
                '5PercentDiscount' => [
                    'sellingPrice' => round($suggestedPrice * 0.95, 2),
                    'costPrice' => round($costPrice),
                    'commission' => round($suggestedPrice * 0.95 * $price->commission),
                    'profit' => round($this->calculateProfit($suggestedPrice * 0.95, $costPrice, $price), 2),
                ],
                'minimumPossibleValue' => [
                    'sellingPrice' => $suggestedPrice = round($this->calculatePriceFromProfit($costPrice, $price), 2),
                    'costPrice' => round($costPrice),
                    'commission' => round($suggestedPrice * $price->commission),
                    'profit' => 0.01
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

    private function calculatePriceFromProfit($costPrice, $price)
    {
        $profit = 0.01;
        $suggestedPrice = ($profit + $costPrice) / (1 - $price->commission - $price->taxes['SimplesNacional']);

        return $suggestedPrice;
    }
}
