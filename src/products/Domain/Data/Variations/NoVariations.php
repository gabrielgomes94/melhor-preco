<?php

namespace Src\Products\Domain\Data\Variations;

use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Variations\Variations;

class NoVariations extends Variations
{
    /**
     * @param \Src\Products\Domain\Entities\Product[] $products
     */
    public function __construct(array $products = [])
    {
        $this->products = [];
    }
}
