<?php

namespace Src\Costs\Domain\DataTransfer;

use Src\Costs\Domain\Models\Contracts\PurchaseItem;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class ProductCosts
{
    /**
     * @param PurchaseItem[] $purchaseItemCosts
     */
    public function __construct(
        public readonly Product $product,
        public readonly array $purchaseItemCosts,
    ) {
    }
}
