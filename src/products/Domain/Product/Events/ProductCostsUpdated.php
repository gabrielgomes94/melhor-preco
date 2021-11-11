<?php

namespace Src\Products\Domain\Product\Events;

class ProductCostsUpdated
{
    private string $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }
}
