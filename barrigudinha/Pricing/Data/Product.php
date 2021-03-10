<?php

namespace Barrigudinha\Pricing\Data;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class Product extends DataTransferObject
{
    private string $sku;
    private int $stock;
    private float $purchasePrice;
//    private Carbon $lastSaleAt;
//    private Carbon $purchasedAt;

    public function __construct(
        string $sku,
        int $stock,
        float $purchasePrice
//        Carbon $lastSaleAt,
//        Carbon $purchasedAt
    ) {
        $this->sku = $sku;
        $this->stock = $stock;
        $this->purchasePrice = $purchasePrice;
//        $this->lastSaleAt = $lastSaleAt;
//        $this->purchasedAt = $purchasedAt;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function stock(): int
    {
        return $this->stock;
    }

    public function purchasePrice(): float
    {
        return $this->purchasePrice;
    }
}

