<?php

namespace Barrigudinha\Pricing\Data;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

/**
 * @deprecated
 * To do: remover essa classe
 */
class CalculatedPrice
{
    private DecimalMoneyFormatter $moneyFormatter;

    private Money $commission;
    private Money $freight;
    private Money $profit;
    private Money $price;
    private Money $costs;
    private Money $taxSimplesNacional;
    private Money $differenceICMS;
    private Money $purchasePrice;
    private float $margin;

    public function __construct(Money $price, Money $costs, Money $commission, Money $freight, Money $taxSimplesNacional, Money $differenceICMS, Money $purchasePrice)
    {
        $this->price = $price;
        $this->costs = $costs;
        $this->commission = $commission;
        $this->freight = $freight;
        $this->taxSimplesNacional = $taxSimplesNacional;
        $this->differenceICMS = $differenceICMS;
        $this->purchasePrice = $purchasePrice;

        $this->profit = $this->setProfit();
        $this->margin = $this->setMargin();

        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function toArray(): array
    {
        return [
            'suggestedPrice' => $this->moneyFormatter->format($this->price),
            'costs' => $this->moneyFormatter->format($this->costs),
            'commission' => $this->moneyFormatter->format($this->commission),
            'freight' => $this->moneyFormatter->format($this->freight),
            'taxSimplesNacional' => $this->moneyFormatter->format($this->taxSimplesNacional),
            'differenceICMS' => $this->moneyFormatter->format($this->differenceICMS),
            'profit' => $this->moneyFormatter->format($this->profit),
            'purchasePrice' => $this->moneyFormatter->format($this->purchasePrice),
            'margin' => $this->margin,
        ];
    }

    private function setMargin(): float
    {
        $margin = 0.0;

        if (!$this->price->isZero()) {
            $margin = $this->profit->ratioOf($this->price);
        }

        return round($margin * 100, 2);
    }

    private function setProfit(): Money
    {
        return $this->price->subtract($this->costs);
    }
}
