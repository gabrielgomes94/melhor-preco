<?php

namespace Barrigudinha\Product;

class Product
{
    private string $sku;
    private string $name;
    private string $brand;

    /**
     * @var string[]
     */
    private array $images;
    private int $stock;
    private ?float $purchasePrice;
    private ?float $price;

    private function __construct(
        string $sku,
        string $name,
        string $brand,
        array $images,
        ?int $stock,
        ?float $purchasePrice,
        ?float $price
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->brand = $brand;
        $this->images = $images;
        $this->stock = (int) $stock ?? 0;
        $this->purchasePrice = $purchasePrice;
        $this->price = $price;
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            sku: $data['sku'],
            name: $data['name'],
            brand: $data['brand'],
            images: $data['images'] ?? [],
            stock: $data['stock'],
            purchasePrice: (float) $data['purchasePrice'],
            price: (float) $data['price']
        );
    }

    public function __get($attribute)
    {
        return $this->{$attribute};
    }
}
