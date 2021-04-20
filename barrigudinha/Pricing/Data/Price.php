<?php

namespace Barrigudinha\Pricing\Data;

use Money\Money;

class Price
{
    private string $id;
    private Money $profit;
    private Money $value;
    private float $commission;
    private string $store;
    private string $storeSkuId;
    private float $additionalCosts;

    public function __construct(
        string $id,
        float $profit,
        float $value,
        float $commission,
        string $store,
        string $storeSkuId,
        string $additionalCosts
    )
    {
        $this->id = $id;
        $this->profit = Money::BRL($profit * 100);
        $this->value = Money::BRL($value * 100);
        $this->commission = $commission;
        $this->store = $store;
        $this->storeSkuId = $storeSkuId;
        $this->additionalCosts = $additionalCosts;
    }

    public function additionalCosts()
    {
        return $this->additionalCosts;
    }

    public function id()
    {
        return $this->id;
    }

    public function commission()
    {
        return $this->commission;
    }

    public function profit()
    {
        return $this->profit;
    }

    public function get()
    {
        return $this->value;
    }

    public function margin()
    {
        return $this->profit->ratioOf($this->value);
    }

    public function storeName()
    {
        return config("stores.{$this->store}.name");
    }
}
