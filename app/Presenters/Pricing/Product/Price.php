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
        $this->value = $price->get();
        $this->profit = $price->profit();
        $this->margin = $price->margin() * 100;
        $this->commission = $price->commission();
        $this->additionalCosts = $price->additionalCosts();
    }
}
