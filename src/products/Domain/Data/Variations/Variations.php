<?php

namespace Src\Products\Domain\Data\Variations;

use Src\Products\Domain\Entities\Product;

class Variations
{
    /**
     * @var Product[]
     */
    protected array $products;

    /**
     * @param \Src\Products\Domain\Entities\Product[] $products
     */
    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    /**
     * @return \Src\Products\Domain\Entities\Product[]
     */
    public function get(): array
    {
        return $this->products;
    }
}
