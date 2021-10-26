<?php

namespace Src\Sales\Domain\Models;

use Src\Sales\Domain\Models\BaseIterator;
use Src\Sales\Domain\Models\SaleOrder;

class SaleOrdersCollection extends BaseIterator
{
    protected function build(array $data): array
    {
        foreach ($data as $saleOrder) {
            if ($saleOrder instanceof SaleOrder) {
                $saleOrders[] = $saleOrder;
            }
        }

        return $saleOrders ?? [];
    }

    public function toArray(): array
    {
        foreach ($this->objects as $saleOrder) {
            $saleOrders[] = $saleOrder->toArray();
        }

        return $saleOrders ?? [];
    }
}
