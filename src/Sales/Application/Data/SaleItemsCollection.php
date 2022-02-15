<?php

namespace Src\Sales\Application\Data;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\Item;

class SaleItemsCollection extends Collection
{
    public function __construct(Collection $sales)
    {
        $sales = $sales->map(function (Item $saleOrder) {
            return $saleOrder;
        });

        parent::__construct($sales);
    }

    public function getTotalData(): array
    {
        [
            'quantity' => $this->count(),
            'value' => $this->sum(function(Item $saleItem) {
                return $saleItem->getTotalValue();
            }),
        ];
    }
}
