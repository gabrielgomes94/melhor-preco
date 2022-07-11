<?php

namespace Src\Sales\Domain\Services\Contracts;

use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

interface CalculateTotalProfit
{
    public function execute(SaleOrder $saleOrder, string $userId): float;
}
