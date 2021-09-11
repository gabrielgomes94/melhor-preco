<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

class Item
{
    private string $sku;
    private string $name;
    private float $quantity;
    private float $unitValue;
    private float $discount;

    public function __construct(
        string $sku,
        string $name,
        float $quantity,
        float $unitValue,
        float $discount
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unitValue = $unitValue;
        $this->discount = $discount;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'unitValue' => $this->unitValue,
            'discount' => $this->discount,
        ];
    }
}
