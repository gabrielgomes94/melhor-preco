<?php


namespace Barrigudinha\Pricing\Data;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class CalculatedPrice
{
    private DecimalMoneyFormatter $moneyFormatter;

    private Money $profit;
    private Money $price;
    private Money $costs;
    private float $margin;

    public function __construct(Money $price, Money $costs)
    {
        $this->price = $price;
        $this->costs = $costs;
        $this->profit = $this->setProfit();
        $this->margin = $this->setMargin();

        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function toArray(): array
    {
        return [
            'suggestedPrice' => $this->moneyFormatter->format($this->price),
            'costs' => $this->moneyFormatter->format($this->costs),
            'profit' => $this->moneyFormatter->format($this->profit),
            'margin' => $this->margin,
        ];
    }

    private function setMargin(): float
    {
        $margin = $this->profit->ratioOf($this->price);

        return round($margin * 100, 2);
    }

    private function setProfit(): Money
    {
        return $this->price->subtract($this->costs);
    }
}
