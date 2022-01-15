<?php

namespace Src\Sales\Domain\Models\ValueObjects\Sale;

class SaleValue
{
    private float $discount;
    private float $freight;
    private float $totalProducts;
    private float $totalValue;

    public function __construct(float $discount, float $freight, float $totalProducts, float $totalValue)
    {
        $this->discount = $discount;
        $this->freight = $freight;
        $this->totalProducts = $totalProducts;
        $this->totalValue = $totalValue;
    }

    public function discount(): float
    {
        return $this->discount;
    }

    public function freight(): float
    {
        return $this->freight;
    }

    public function totalValue(): float
    {
        return $this->totalValue;
    }

    public function totalProducts(): float
    {
        return $this->totalProducts;
    }

    public function toArray(): array
    {
        return [
            'discount' => $this->discount,
            'freight' => $this->freight,
            'totalProducts' => $this->totalProducts,
            'totalValue' => $this->totalValue,
        ];
    }
}
