<?php

namespace Src\Marketplaces\Domain\Models\Commission\Base;

class CommissionValuesCollection
{
    private array $items;
    private ?float $maximumCapValue;

    public function __construct(array $items = [], ?float $maximumCapValue = null)
    {
        foreach($items as $item) {
            if ($item instanceof CommissionValue) {
                $data[] = $item;
            }
        }

        $this->items = $data ?? [];
        $this->maximumCapValue = $maximumCapValue;
    }

    public function get(): array
    {
        return $this->items;
    }

    public function first(): ?CommissionValue
    {
        $items = $this->items;

        return array_shift($items);
    }

    public function getMaximumCapValue(): ?float
    {
        return $this->maximumCapValue;
    }
}
