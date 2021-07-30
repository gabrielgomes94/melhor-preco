<?php

namespace Integrations\Bling\Products\Data;

class Product
{
    private string $erpId;
    private string $sku;
    private string $name;
    private string $brand;
    private array $images;
    private int $stock;
    private float $purchasePrice;
    private float $price;
    private float $depth;
    private float $height;
    private float $width;
    private float $weight;
    private ?string $parentSku;
    private bool $hasVariations;
    private array $stores;

    private function __construct(array $data)
    {
        $this->erpId = $data['erpId'];
        $this->sku = $data['sku'];
        $this->name = $data['name'];
        $this->brand = $data['brand'];
        $this->images = $data['images'] ?? [];
        $this->stock = $data['stock'];
        $this->purchasePrice = $data['purchasePrice'];
        $this->price = $data['price'];
        $this->depth = $data['depth'];
        $this->height = $data['height'];
        $this->width = $data['width'];
        $this->weight = $data['weight'];
        $this->parentSku = $data['parentSku'] ?? null;
        $this->hasVariations = $data['hasVariations'] ?? false;
    }

    public static function createFromArray(array $data): self
    {
        return new self($data);
    }

    public function addStore(Store $store)
    {
        $this->stores[] = $store;
    }

    public function hasStore()
    {
        return !empty($this->stores);
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function stores(): array
    {
        return $this->stores;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->sku,
            'erp_id' => $this->erpId,
            'sku' => $this->sku,
            'name' => $this->name,
            'purchase_price' => $this->purchasePrice,
            'depth' => $this->depth,
            'height' => $this->height,
            'width' => $this->width,
            'weight' => $this->weight,
            'parent_sku' => $this->parentSku,
            'has_variations' => $this->hasVariations,
            'stores' => $this->getStores(),
        ];
    }

    private function getStores(): array
    {
        return array_map(
            function (Store $store) {
                return $store->toArray();
            },
            $this->stores
        );
    }
}
