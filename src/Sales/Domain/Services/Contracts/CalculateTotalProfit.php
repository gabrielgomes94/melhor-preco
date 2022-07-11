<?php

namespace Src\Sales\Domain\Services\Contracts;

use Src\Sales\Domain\Models\Contracts\SaleOrder;

interface CalculateTotalProfit
{
    public function execute(SaleOrder $saleOrder, string $userId): float;
}
