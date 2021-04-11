<?php

namespace Barrigudinha\Pricing\Data;

use Barrigudinha\Product\Product as ProductData;

class Product
{
    private string $sku;
    private string $name;
    private float $purchasePrice;

    /**
     * @var Price[] $prices
     */
    private array $prices;
    private array $taxes;

    public function __construct(array $data)
    {
        $this->fill($data);
    }

//    public static function fromModel(array $data)
//    {
//        new self
//        return self;
//    }

    private function fill(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->sku = $data['sku'];
        $this->purchasePrice = $data['purchase_price'];

        foreach($data['stores'] ?? [] as $store) {
            $this->stores[] = $store;
        }
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
            'purchase_price' => $this->purchasePrice,
            'name' => $this->name,
            'tax_ipi' => 0.0,
            'tax_icms' => 0.0,
            'tax_simples_nacional' => 0.0,
        ];
    }
}
