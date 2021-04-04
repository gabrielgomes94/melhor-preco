<?php

namespace Barrigudinha\Pricing\Data;

use Barrigudinha\Product\Product as ProductData;

class Product
{
    private string $name;
    private string $sku;
    private float $purchasePrice;
    private array $shops;
    private array $taxes;

    public function __construct(array $data)
    {
        $this->fill($data);
    }

    private function fill(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->sku = $data['sku'];
        $this->purchasePrice = $data['purchase_price'];
        $this->shops = [
            [
                'code' => 'magalu',
                'sku' => $data['sku_magalu'] ?? null,
            ],
            [
                'code' => 'b2w',
                'sku' => $data['sku_b2w'] ?? null,
            ],
            [
                'code' => 'mercado_livre',
                'sku' => $data['sku_mercado_livre'] ?? null,
            ],
        ];
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
            'sku_magalu' => $this->shops[0]['sku'],
            'sku_b2w' => null,
            'sku_mercado_livre' => null,
            'tax_ipi' => 0.0,
            'tax_icms' => 0.0,
            'tax_simples_nacional' => 0.0,
        ];
    }
}
