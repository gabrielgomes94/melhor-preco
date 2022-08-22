<?php

namespace Src\Products\Domain\Models\ValueObjects;

use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class Variations
{
    protected array $products;
    protected ?string $parentSku;

    public function __construct(?string $parentSku = null, array $products = [])
    {
        $this->parentSku = $parentSku;

        foreach ($products as $product) {
            if ($product instanceof Product) {
                $variationProducts[] = $product;
            }
        }
        $this->products = $variationProducts ?? [];
    }

    public function get(): array
    {
        return $this->products;
    }

    public function getParentSku(): ?string
    {
        return $this->parentSku ?? null;
    }
}
