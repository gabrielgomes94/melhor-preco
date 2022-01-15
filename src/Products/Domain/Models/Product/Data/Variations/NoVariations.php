<?php

namespace Src\Products\Domain\Models\Product\Data\Variations;

class NoVariations extends Variations
{
    /**
     * @param \Src\Products\Domain\Entities\Product[] $products
     */
    public function __construct(string $parentSku = '', array $products = [])
    {
        parent::__construct($parentSku, $products);

        $this->products = [];
    }
}
