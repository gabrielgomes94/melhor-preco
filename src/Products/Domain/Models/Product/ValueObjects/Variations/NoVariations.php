<?php

namespace Src\Products\Domain\Models\Product\ValueObjects\Variations;

use Src\Products\Domain\Models\Product\Product;

class NoVariations extends Variations
{
    /**
     * @param Product[] $products
     */
    public function __construct(string $parentSku = '', array $products = [])
    {
        parent::__construct($parentSku, $products);

        $this->products = [];
    }
}
