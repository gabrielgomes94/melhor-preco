<?php

namespace Src\Sales\Application\Data;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\Item;

class SaleItemsCollection
{
    public readonly Collection $saleItems;

    public function __construct(Collection $saleItems){

        $this->saleItems = $saleItems->map(function (Item $saleItem) {
            return $saleItem;
        });
    }

    public function get(): Collection
    {
        return $this->saleItems;
    }
}
