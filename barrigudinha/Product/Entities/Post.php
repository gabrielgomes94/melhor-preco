<?php

namespace Barrigudinha\Product\Entities;

use Barrigudinha\Product\Data\Store;
use Barrigudinha\Utils\Helpers;
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

    public function setPrice(Money $price, Money $profit): void
    {
        $this->price = $price;
        $this->profit = $profit;
    }

    public function margin(): float
    {
        if ($this->price->isZero()) {
            return 0.0;
        }

        return $this->profit->ratioOf($this->price);
    }

    public function isInMarginRange(float $minimumProfit, float $maximumProfit)
    {
        $minimumProfit = Helpers::percentage($minimumProfit);
        $maximumProfit = Helpers::percentage($maximumProfit);

        return $minimumProfit <= $this->margin() && $this->margin() <= $maximumProfit;
    }
}
