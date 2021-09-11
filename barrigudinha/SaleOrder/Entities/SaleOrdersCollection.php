<?php

namespace Barrigudinha\SaleOrder\Entities;

use Barrigudinha\Utils\BaseIterator;

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
}
