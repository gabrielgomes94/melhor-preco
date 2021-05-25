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
    private ?Carbon $createdAt;
    private ?Carbon $updatedAt;

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
        $this->commission = config('stores.b2w.commission'); // TODO: configurar config para pegar commissions
        $this->code = $code;
        $this->price = $price;
        $this->promotionalPrice = $promotionalPrice;
        $this->createdAt = $this->setDate($createdAt);
        $this->updatedAt = $this->setDate($updatedAt);
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            store_sku_id: $data['skuStoreId'],
            code: $data['code'],
            price: $data['price'],
            promotionalPrice: $data['promotionalPrice'],
            createdAt: $data['createdAt'],
            updatedAt: $data['updatedAt']
        );
    }

    public function storeSkuId(): string
    {
        return $this->store_sku_id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function price(): float
    {
        return $this->price;
    }

    private function setDate(string $date): ?Carbon
    {
        if ($date = Carbon::createFromFormat('Y-m-d', $date)) {
            return $date;
        }

        return null;
    }
}
