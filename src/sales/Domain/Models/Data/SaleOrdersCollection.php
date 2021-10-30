<?php

namespace Src\Sales\Domain\Models\Data;

use Src\Sales\Domain\Models\Data\BaseIterator;
use Src\Sales\Domain\Models\Data;
use Src\Sales\Domain\Models\Data\SaleOrder;

class SaleOrdersCollection extends BaseIterator
{
    protected function build(array $data): array
    {
        foreach ($data as $saleOrder) {
            if ($saleOrder instanceof Data\SaleOrder) {
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
