<?php

namespace Barrigudinha\Pricing\Data;

class Pricing
{
    public string $name;

    public array $products;

    public array $stores;

    public function __construct(string $name, array $products, array $stores)
    {
        $this->name = $name;
        $this->products = $products;
        $this->stores = $stores;
    }
}
