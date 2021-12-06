<?php

namespace Src\Sales\Infrastructure\Eloquent;

use Illuminate\Support\Collection;
use Src\Sales\Domain\Models\Item;
use Src\Sales\Domain\Repositories\Contracts\ItemRepository as ItemRepositoryRepository;

class ItemRepository implements ItemRepositoryRepository
{
    public static function groupSaleItemsByProduct(): Collection
    {
        return Item::with('product')
            ->get()
            ->groupBy('sku');
    }
}
