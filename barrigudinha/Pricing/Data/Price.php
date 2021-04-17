<?php

namespace Barrigudinha\Pricing\Data;

class Price
{
    private string $id;
    private float $profit;
    private float $value;
    private float $commission;
    private string $store;
    private string $storeSkuId;

    public function __construct(string $id, float $profit, float $value, float $commission, string $store, string $storeSkuId)
    {
        $this->id = $id;
        $this->profit = $profit;
        $this->value = $value;
        $this->commission = $commission;
        $this->store = $store;
        $this->storeSkuId = $storeSkuId;
    }

    public function id()
    {
        return $this->id;
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
        return $this->profit / $this->value;
    }

    public function storeName()
    {
        return config("stores.{$this->store}.name");
    }
}
