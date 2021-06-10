<?php

namespace Barrigudinha\Product;

use Money\Money;

class Post
{
    private ?string $id;
    private Money $price;
    private Store $store;

    public function __construct(?string $id, Money $price, Store $store)
    {
        $this->id = $id;
        $this->price = $price;
        $this->store = $store;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function store(): Store
    {
        return $this->store;
    }
}
