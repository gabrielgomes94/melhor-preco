<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Pricing\Data\Price as PriceData;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class Price
{
    public string $id;
    public string $store;
    public string $commission;
    public string $value;
    public string $profit;
    public string $margin;
    public string $additionalCosts;

    public function __construct(PriceData $price)
    {
        $this->moneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $this->id = $price->id();
        $this->store = $price->storeName();
        $this->value = $this->setMoneyValue($price->get());
        $this->profit = $this->setMoneyValue($price->profit());

        $this->margin =  $this->setMargin($price->margin());
        $this->commission = $price->commission();
        $this->additionalCosts = $price->additionalCosts();
    }

    private function setMoneyValue(Money $value)
    {
        return $this->moneyFormatter->format($value);
    }

    private function setMargin(float $margin)
    {
        $margin = round(($margin * 100), 2);

        return (string) $margin;
    }
}
