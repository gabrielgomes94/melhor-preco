<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

/**
 * To Do: Tornar esse objeto um Iterator
 */
class Items
{
    private array $items;

    public function __construct(array $items)
    {
        $this->build($items);
    }

    public function toArray(): array
    {
        return array_map(function (Item $item) {
            return $item->toArray();
        }, $this->items);
    }

    private function build(array $items)
    {
        foreach ($items as $item) {
            if ($item instanceof Item) {
                $this->items[] = $item;
            }
        }
    }
}
