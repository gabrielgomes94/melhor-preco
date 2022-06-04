<?php

namespace Src\Costs\Infrastructure\NFe\Data;

class Product
{
    private function __construct(
        public readonly float $discount,
        public readonly string $ean,
        public readonly string $name,
        public readonly float $price,
        public readonly float $quantity,
        public readonly float $totalFreight,
        public readonly float $totalInsurance,
        public readonly Taxes $taxes
    )
    {
    }

    public static function fromArray(array $data): static
    {
        $product = $data['prod'] ?? [];
        $taxes = $data['imposto'] ?? [];

        return new static(
            discount: $product['vDesc'] ?? 0.0,
            ean: $product['cEAN'] ?? '',
            name: $product['xProd'] ?? '',
            price: $product['vUnCom'] ?? $product['vUnTrib'] ?? 0.0,
            quantity: $product['qCom'] ?? $product['qTrib'] ?? 0.0,
            totalFreight: $product['vFrete'] ?? 0.0,
            totalInsurance: $product['vSeg'] ?? 0.0,
            taxes: Taxes::fromArray($taxes),
        );
    }

    public function getUnitFreightValue(): float
    {
        if ($this->quantity === 0.0) {
            return 0.0;
        }

        return $this->totalFreight / $this->quantity;
    }

    public function getUnitInsuranceValue(): float
    {
        if ($this->quantity === 0.0) {
            return 0.0;
        }

        return $this->totalInsurance  / $this->quantity;
    }
}
