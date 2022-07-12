<?php

namespace Src\Sales\Domain\DataTransfer;

use Illuminate\Support\Collection;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class SaleItemsCollection
{
    public array $saleItems = [];

    public function __construct(array $saleItems)
    {
        foreach ($saleItems as $saleItem) {
            if ($saleItem instanceof Item) {
                $this->saleItems[] = $saleItem;
            }
        }
    }

    public function get(): array
    {
        return $this->saleItems;
    }
}
