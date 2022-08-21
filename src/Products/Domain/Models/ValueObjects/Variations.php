<?php

namespace Src\Products\Domain\Models\ValueObjects;

class Variations
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
