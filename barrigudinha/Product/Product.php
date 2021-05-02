<?php

namespace Barrigudinha\Product;

use Barrigudinha\Pricing\Data\Product as PricingProduct;

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

    /**
     * Store[] array
     */
    public array $stores = [];

    private function __construct(
        string $sku,
        string $name,
        string $brand,
        array $images,
        ?int $stock,
        ?float $purchasePrice,
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->brand = $brand;
        $this->images = $images;
        $this->stock = (int) $stock ?? 0;
        $this->purchasePrice = $purchasePrice;
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
        );
    }

    public function __get($attribute)
    {
        return $this->{$attribute};
    }

    public function addStore(Store $storeInfo)
    {
        $this->stores[] = $storeInfo;
    }

    public function toPricing(): PricingProduct
    {
        return new PricingProduct([
            'name' => $this->name,
            'sku' => $this->sku,
            'purchase_price' => $this->purchasePrice ?? 0.0,
            'stores' => $this->stores,
        ]);
    }
}
