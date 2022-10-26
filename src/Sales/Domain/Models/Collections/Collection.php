<?php

namespace Src\Sales\Domain\Models\Collections;

class Collection
{
    protected array $items = [];

    public function __construct(array $items, string $className)
    {
        foreach ($items as $item) {
            if ($item instanceof $className) {
                $this->items[] = $item;
            }
        }
    }

    public function get(): array
    {
        return $this->items;
    }
}
