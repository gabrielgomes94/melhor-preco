<?php

namespace Src\Products\Domain\Product\Models\Data\Variations;

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
