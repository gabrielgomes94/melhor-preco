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

    public function __construct(Money $profit, Money $price, Money $costs)
    {
        $this->profit = $profit;
        $this->price = $price;
        $this->costs = $costs;
        $this->margin = $this->setMargin();

        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    private function setMargin(): float
    {
        $margin = $this->profit->ratioOf($this->price);

        return round($margin * 100, 2);
    }

    public function toArray(): array
    {
        return [
            'profit' => $this->moneyFormatter->format($this->profit),
            'costs' => $this->moneyFormatter->format($this->costs),
            'suggestedPrice' => $this->moneyFormatter->format($this->price),
            'margin' => $this->margin,
        ];
    }
}
