<?php

namespace Src\Marketplaces\Domain\Models\Commission\Base;

class CommissionValuesCollection
{
    private array $items;

    public function __construct(array $items = [])
    {
        foreach($items as $item) {
            if ($item instanceof CommissionValue) {
                $data[] = $item;
            }
        }

        $this->items = $data ?? [];
    }

    public function get(): array
    {
        return $this->items;
    }

    public function first(): CommissionValue
    {
        $items = $this->items;

        return array_shift($items);
    }
}
