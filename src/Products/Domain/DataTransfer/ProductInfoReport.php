<?php

namespace Src\Products\Domain\DataTransfer;

use Src\Products\Domain\Models\Product;
use Src\Sales\Domain\Reports\Product\ProductSales;

class ProductInfoReport
{
    public function __construct(
        public readonly array $costsItems,
        public readonly Product $product,
        public readonly ProductSales $productSales,
        public readonly array $marketplaceSales
    )
    {
    }
}
