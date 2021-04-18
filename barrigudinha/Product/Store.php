<?php

namespace Barrigudinha\Product;

use Carbon\Carbon;

class Store
{
    private string $store_sku_id;
    private string $code;
    private float $commission;
    private float $price;
    private float $promotionalPrice;
    private Carbon $createdAt;
    private Carbon $updatedAt;

    public function __construct(
        string $store_sku_id,
        string $code,
        float $price,
        float $promotionalPrice,
        string $createdAt,
        string $updatedAt
    ) {
        if (!in_array($code, array_keys(config('stores_code')))) {
            throw new \Exception('Invalid object store');
        }

        $this->store_sku_id = $store_sku_id;
        $this->code = $code;
        $this->price = $price;
        $this->promotionalPrice = $promotionalPrice;
        $this->createdAt = Carbon::createFromFormat('Y-m-d', $createdAt);
        $this->updatedAt = Carbon::createFromFormat('Y-m-d', $updatedAt);
    }

    public function storeSkuId(): string
    {
        return $this->store_sku_id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function price(): string
    {
        return $this->price;
    }
}

