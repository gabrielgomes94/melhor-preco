<?php

namespace Src\Sales\Domain\Reports\Product;

class ProductSalesCollection
{
    private array $items;

    public function __construct(array $productSalesCollection = [])
    {
        foreach ($productSalesCollection as $productSales) {
            if ($productSales instanceof \Src\Sales\Domain\Reports\Product\ProductSales) {
                $this->items[] = $productSales;
            }
        }
    }

    public function get(): array
    {
        return $this->items;
    }
}
