<?php

namespace Integrations\Bling\Products\Responses\Data;

class Store
{
    private string $slug;
    private string $storeSkuId;
    private float $price;
    private float $promotionalPrice;
    private string $createdAt;
    private string $updatedAt;

    private function __construct(array $data)
    {
        $this->slug = $data['code'];
        $this->storeSkuId = $data['storeSkuId'];
        $this->price = $data['price'];
        $this->promotionalPrice = $data['promotionalPrice'];
        $this->createdAt = $data['createdAt'];
        $this->updatedAt = $data['updatedAt'];
    }

    public static function createFromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'storeSkuId' => $this->storeSkuId,
            'price' => $this->price,
            'promotionalPrice' => $this->promotionalPrice,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
