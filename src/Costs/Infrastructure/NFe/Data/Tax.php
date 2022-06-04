<?php

namespace Src\Costs\Infrastructure\NFe\Data;

use Src\Math\Percentage;

class Tax
{
    public function __construct(
        public readonly string $name,
        public readonly float $value,
        public readonly Percentage $percentage
    )
    {}

    public function toArray()
    {
        return [
            'value' => $this->value,
            'percentage' => $this->percentage->get(),
        ];
    }
}
