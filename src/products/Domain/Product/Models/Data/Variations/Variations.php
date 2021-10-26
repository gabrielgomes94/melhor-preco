<?php

namespace Src\Products\Domain\Product\Models\Data\Variations;

use Src\Products\Domain\Product\Contracts\Models\Data\Variations\Variations as VariationsInterface;

class Variations implements VariationsInterface
{
    protected array $products;
    protected ?string $parentSku;

    public function __construct(?string $parentSku = null, array $products = [])
    {
        $this->parentSku = $parentSku;
        $this->products = $products;
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
