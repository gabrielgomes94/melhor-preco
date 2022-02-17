<?php

namespace Src\Sales\Application\Data;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\Contracts\SaleOrder;
use Src\Sales\Domain\Models\Item;

class SaleOrdersCollection extends Collection
{
    public function __construct(Collection $sales)
    {
        $sales = $sales->map(function (SaleOrder $saleOrder) {
            return $saleOrder;
        });

        parent::__construct($sales);
    }
}
