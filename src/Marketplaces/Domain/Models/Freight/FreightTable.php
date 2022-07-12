<?php

namespace Src\Marketplaces\Domain\Models\Freight;

class FreightTable
{
    private array $components = [];

    public function __construct(array $components)
    {
        foreach ($components as $component) {
            if ($component instanceof FreightTableComponent) {
                $this->components[] = $component;
            }
        }
    }

    public function get(): array
    {
        return $this->components;
    }
}
