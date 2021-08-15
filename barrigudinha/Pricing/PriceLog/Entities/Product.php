<?php

namespace Barrigudinha\Pricing\PriceLog\Entities;

use Carbon\Carbon;
use DateTime;

class Product
{
    private string $sku;
    private string $name;
    private string $store;
    private float $price;
    private float $profit;
    private Carbon $updatedAt;

    public function __construct(string $sku, string $name, string $store, float $price, float $profit, Carbon $updatedAt)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->store = $store;
        $this->price = $price;
        $this->profit = $profit;
        $this->updatedAt = $updatedAt;
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'store' => $this->store,
            'name' => $this->name,
            'price' => $this->price,
            'profit' => $this->profit,
            'updatedAt' => $this->updatedAt->format('d/m/Y H:i:s'),
        ];
    }
}
