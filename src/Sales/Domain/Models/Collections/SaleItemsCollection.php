<?php

namespace Src\Sales\Domain\Models\Collections;

use Src\Sales\Infrastructure\Laravel\Models\Item;

class SaleItemsCollection extends Collection
{
    public function __construct(array $saleItems)
    {
        parent::__construct($saleItems, Item::class);
    }
}
