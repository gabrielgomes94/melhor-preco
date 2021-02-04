<?php


namespace App\Bling\Prices;


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

    public function calculate($sku, $buy_price)
    {
        $buy_price = (float) $buy_price;

        $costPrice = $buy_price *
            (1 + $this->configs['taxes']['IPI']) *
            (1 + $this->configs['taxes']['ICMS']) *
            (1 + $this->configs['taxes']['SimplesNacional']);

        $suggestedPrice = $costPrice / (1 - $this->configs['comission'] - $this->configs['taxes']['SimplesNacional'] - $this->configs['profitMargin']);

        $profit = $this->calculateProfit($suggestedPrice, $costPrice);

        return [
            'buyPrice' => $buy_price,
            'costPrice' => $costPrice,
            'taxes' => [
                'IPI' => $buy_price * ($this->configs['taxes']['IPI']),
                'ICMS' => $buy_price * ($this->configs['taxes']['ICMS']),
            ],
            'suggestedPrices' => [
                'normal' => [
                    'sellingPrice' => $suggestedPrice,
                    'profit' => $profit,
                ],
                '5PercentDiscount' => [
                    'sellingPrice' => $suggestedPrice * 0.95,
                    'profit' => $this->calculateProfit($suggestedPrice * 0.95, $costPrice),
                ]
            ],
        ];
    }

    private function calculateProfit($suggestedPrice, $costPrice)
    {
        $profit = $suggestedPrice - ($costPrice
                + ($suggestedPrice * $this->configs['comission'])
                + ($suggestedPrice * $this->configs['taxes']['SimplesNacional']));

        return $profit;
    }
}
