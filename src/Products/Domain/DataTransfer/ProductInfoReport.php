<?php

namespace Src\Products\Domain\DataTransfer;

use Illuminate\Support\Collection;
use Src\Products\Domain\Models\Product\Product;
use Src\Sales\Application\Data\Reports\SalesReport;

class ProductInfoReport
{
public function __construct(
    public readonly Collection $costsItems,
    public readonly Product $product,
    public readonly SalesReport $salesReport
) {
}
