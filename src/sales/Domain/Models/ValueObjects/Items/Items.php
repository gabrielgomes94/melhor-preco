<?php

namespace Src\Sales\Domain\Models\ValueObjects\Items;

class Items
{
    private array $items;

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function get(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return array_map(function (Item $item) {
            return $item->toArray();
        }, $this->items);
    }

    private function fill(array $data): void
    {
        foreach ($data as $item) {
            if ($item instanceof Item) {
                $this->items[] = $item;
            }
        }
    }
}
