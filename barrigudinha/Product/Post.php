<?php

namespace Barrigudinha\Product;

use Money\Money;

class Post
{
    private ?string $id;
    private Money $price;
    private ?Money $profit;
    private Store $store;

    public function __construct(?string $id, Money $price, Store $store, ?Money $profit = null)
    {
        $this->id = $id;
        $this->price = $price;
        $this->store = $store;
        $this->profit = $profit;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function profit(): Money
    {
        return $this->profit ?? Money::BRL(0);
    }


    public function store(): Store
    {
        return $this->store;
    }

    public function setProfit(Money $profit): void
    {
        $this->profit = $profit;
    }
}
