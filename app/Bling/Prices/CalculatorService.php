<?php
namespace App\Bling\Prices;

use App\Barrigudinha\Prices\Price;

class CalculatorService
{
    public function calculate(Price $price)
    {
        if ($price->desiredSellingPrice) {
            return $this->calculateFromDesiredSellingPrice($price);
        }

        $costPrice = $price->purchasePrice *
            (1 + $price->taxes['IPI']) *
            (1 + $price->taxes['ICMSDifference']);

        $price->costPrice = $costPrice;

        $suggestedPrice = $costPrice /
            (1 - $price->commission - $price->taxes['SimplesNacional'] - $price->profitMargin);

        $price->salePrice = round($suggestedPrice, 2);

        $profit = $this->calculateProfit($suggestedPrice, $costPrice, $price);

        return [
            'salePrices' => [
                'normal' => [
                    'sellingPrice' => round($suggestedPrice, 2),
                    'costPrice' => round($costPrice, 2),
                    'commission' => round($suggestedPrice * $price->commission, 2),
                    'profit' => round($profit, 2),
                ],
                '5PercentDiscount' => [
                    'sellingPrice' => round($suggestedPrice * 0.95, 2),
                    'costPrice' => round($costPrice, 2),
                    'commission' => round($suggestedPrice * 0.95 * $price->commission, 2),
                    'profit' => round($this->calculateProfit($suggestedPrice * 0.95, $costPrice, $price), 2),
                ],
                'minimumPossibleValue' => [
                    'sellingPrice' => $suggestedPrice = round($this->calculatePriceFromProfit($costPrice, $price), 2),
                    'costPrice' => round($costPrice, 2),
                    'commission' => round($suggestedPrice * $price->commission, 2),
                    'profit' => 0.01
                ]
            ],
        ];
    }

    private function calculateProfit($suggestedPrice, $costPrice, $price)
    {
        $profit = $suggestedPrice - ($costPrice + ($suggestedPrice * $price->commission) + ($suggestedPrice * $price->taxes['SimplesNacional']) + $price->freight);

        return $profit;
    }

    private function calculatePriceFromProfit($costPrice, $price)
    {
        $profit = 0.01;
        $suggestedPrice = ($profit + $costPrice) / (1 - $price->commission - $price->taxes['SimplesNacional']);

        return $suggestedPrice;
    }

    private function calculateFromDesiredSellingPrice(Price $price)
    {
        $costPrice = $price->purchasePrice *
            (1 + $price->taxes['IPI']) *
            (1 + $price->taxes['ICMSDifference']);

        $price->costPrice = $costPrice;

        $profit = $this->calculateProfit($price->desiredSellingPrice, $costPrice, $price);

        return [
            'salePrices' => [
                'normal' => [
                    'sellingPrice' => round($price->desiredSellingPrice, 2),
                    'costPrice' => round($costPrice, 2),
                    'commission' => round($price->desiredSellingPrice * $price->commission, 2),
                    'profit' => round($profit, 2),
                ],
                '5PercentDiscount' => [
                    'sellingPrice' => round($price->desiredSellingPrice * 0.95, 2),
                    'costPrice' => round($costPrice, 2),
                    'commission' => round($price->desiredSellingPrice * 0.95 * $price->commission, 2),
                    'profit' => round($this->calculateProfit($price->desiredSellingPrice * 0.95, $costPrice, $price), 2),
                ],
                'minimumPossibleValue' => [
                    'sellingPrice' => $suggestedPrice = round($this->calculatePriceFromProfit($costPrice, $price), 2),
                    'costPrice' => round($costPrice, 2),
                    'commission' => round($suggestedPrice * $price->commission, 2),
                    'profit' => 0.01
                ],
            ]
        ];
    }
}
