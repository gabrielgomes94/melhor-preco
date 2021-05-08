<?php

namespace Barrigudinha\Pricing\Data;

use Barrigudinha\Product\Dimensions;
use Barrigudinha\Product\Product as ProductData;

class Product
{
    private string $id;
    private string $sku;
    private string $name;
    private float $purchasePrice;

    /**
     * @var Price[] $prices
     */
    private array $prices;

    /**
     * @var Tax[] $taxes
     */
    private array $taxes;

    private float $additionalCosts;
    private Dimensions $dimensions;

    public function __construct(array $data, array $prices = [])
    {
        $this->fill($data);
        $this->setPrices($prices);
    }

    private function fill(array $data)
    {
        $this->id = $data['id'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->sku = $data['sku'];
        $this->purchasePrice = $data['purchase_price'];

        foreach($data['stores'] ?? [] as $store) {
            $this->stores[] = $store;
        }

        $this->taxes[] = new Tax(Tax::IPI, 'in', $data['tax_ipi'] ?? 0.0);
        $this->taxes[] = new Tax(Tax::ICMS, 'in', $data['tax_icms'] ?? 0.0);
        $this->taxes[] = new Tax(Tax::SIMPLES_NACIONAL, 'out', $data['tax_simples_nacional'] ?? 4.65);

        $this->additionalCosts = (float) ($data['additional_costs'] ?? 0.0);

        $this->dimensions = new Dimensions(
            depth: $data['depth'],
            height: $data['height'],
            width: $data['width']
        );
    }

    private function setPrices(array $data)
    {
        foreach($data as $price)
        {
            $this->prices[] = new Price(
                id: $price['id'],
                profit: $price['profit'],
                value: $price['value'],
                commission: $price['commission'],
                store: $price['store'],
                storeSkuId: $price['store_sku_id'],
                additionalCosts: $price['additional_costs'] ?? 0.0
            );
        }
    }

    public function additionalCosts(): float
    {
        return $this->additionalCosts;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function dimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function prices(): array
    {
        return $this->prices;
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

    public function tax(string $taxCode): ?Tax
    {
        foreach($this->taxes as $tax) {
            if ($taxCode === $tax->name) {
                return $tax;
            }
        }

        return null;
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
