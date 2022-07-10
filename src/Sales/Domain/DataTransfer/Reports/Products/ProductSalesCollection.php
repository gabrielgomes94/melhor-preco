<?php

namespace Src\Sales\Domain\DataTransfer\Reports\Products;

use Src\Sales\Domain\DataTransfer\Reports\Products\ProductSales;

class ProductSalesCollection
{
    private array $items;

    public function __construct(array $productSalesCollection = [])
    {
        foreach ($productSalesCollection as $productSales) {
            if ($productSales instanceof ProductSales) {
                $this->items[] = $productSales;
            }
        }
    }

    public function get(): array
    {
        return $this->items;
    }
}
