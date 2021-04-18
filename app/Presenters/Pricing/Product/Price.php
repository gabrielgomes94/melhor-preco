<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Pricing\Data\Price as PriceData;

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
        $this->id = $price->id();
        $this->store = $price->storeName();
        $this->value = 'R$ ' . $price->get();
        $this->profit = 'R$ ' . $price->profit();
        $this->margin = $price->margin() . '%';
        $this->commission = $price->commission();
        $this->additionalCosts = $price->additionalCosts();
    }
}
