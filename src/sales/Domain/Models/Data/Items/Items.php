<?php

namespace Src\Sales\Domain\Models\Data\Items;

use Src\Sales\Domain\Models\Data\Items\Item;
use Src\Sales\Domain\Models\Data\BaseIterator;

class Items extends BaseIterator
{
    private array $items;

    public function toArray(): array
    {
        return array_map(function (Item $item) {
            return $item->toArray();
        }, $this->items);
    }

    protected  function build(array $data): array
    {
        foreach ($data as $item) {
            if ($item instanceof Item) {
                $items[] = $item;
            }
        }

        return $items ?? [];
    }
}
