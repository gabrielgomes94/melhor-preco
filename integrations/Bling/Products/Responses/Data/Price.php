<?php

namespace Integrations\Bling\Products\Responses\Data;

class Price
{
    private string $skuStoreId;
    private float $price;
    private float $promotionalPrice;

    private function __construct(array $data)
    {
        $this->skuStoreId = $data['skuStoreId'];
        $this->price = $this->getValue($data['price']);
        $this->promotionalPrice = $this->getValue($data['promotionalPrice']);
    }

    public static function createFromArray(array $data): self
    {
        return new self($data);
    }

    private function getValue(string $value): float
    {
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }
}
