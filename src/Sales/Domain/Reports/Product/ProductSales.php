<?php

namespace Src\Sales\Domain\Reports\Product;

use Src\Products\Domain\Models\Product;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;

interface ProductSales
{
    public function getProduct(): Product;

    public function getSaleItems(): SaleItemsCollection;

    public function getAveragePrice(): float;

    public function count(): int;

    public function getAverageProfit(): float;

    public function getAverageMargin(): float;

    public function getTotalRevenue(): float;

    public function getTotalProfit(): float;

    public function getLastSales(): SaleItemsCollection;
}
