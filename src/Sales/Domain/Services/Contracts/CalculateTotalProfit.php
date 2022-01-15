<?php

namespace Src\Sales\Domain\Services\Contracts;

use Src\Sales\Domain\Models\SaleOrder;

interface CalculateTotalProfit
{
    public function execute(SaleOrder $saleOrder): float;
}
