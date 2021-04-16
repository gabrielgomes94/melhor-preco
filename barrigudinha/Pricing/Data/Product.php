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

    /**
     * @var Tax[] $taxes
     */
    private array $taxes;

    private float $additionalCosts;

    public function __construct(array $data)
    {
        $this->fill($data);
    }

    private function fill(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->sku = $data['sku'];
        $this->purchasePrice = $data['purchase_price'];

        foreach($data['stores'] ?? [] as $store) {
            $this->stores[] = $store;
        }

        $this->taxes[] = new Tax('ipi', 'in', $data['tax_ipi']);
        $this->taxes[] = new Tax('icms', 'in', $data['tax_icms']);
        $this->taxes[] = new Tax('simples_nacional', 'out', $data['tax_simples_nacional']);

        $this->additionalCosts = (float) $data['additional_costs'] ?? 0.0;
    }

    public function additionalCosts(): float
    {
        return $this->additionalCosts;
    }

    public function name(): string
    {
        return $this->name;
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
