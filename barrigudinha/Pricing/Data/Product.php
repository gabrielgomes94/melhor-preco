<?php

namespace Barrigudinha\Pricing\Data;

use Barrigudinha\Product\Product as ProductData;

class Product
{
    private string $sku;
    private int $stock;
    private float $purchasePrice;

    public function __construct(string $sku, string $stock, float $purchasePrice) {
        $this->sku = $sku;
        $this->stock = $stock;
        $this->purchasePrice = $purchasePrice;
    }

    public static function createFromProduct(ProductData $product): self
    {
        return new self($product->sku, $product->stock, $product->purchasePrice);
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

    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'stock' => $this->stock,
            'purchasePrice' => $this->purchasePrice,
        ];
    }
}
