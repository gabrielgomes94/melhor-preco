<?php

namespace Src\Sales\Domain\Models\Collections;

use Src\Sales\Domain\Models\Contracts\SaleOrder;

class SaleOrdersCollection extends Collection
{
    public function __construct(array $sales)
    {
        parent::__construct($sales, SaleOrder::class);
    }
}
