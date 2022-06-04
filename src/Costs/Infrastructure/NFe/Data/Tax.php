<?php

namespace Src\Costs\Infrastructure\NFe\Data;

use Src\Math\Percentage;

class Tax
{
    private function __construct(
        public readonly string $name,
        public readonly float $value,
        public readonly Percentage $percentage
    )
    {}

    public static function fromArray(string $taxName, array $data = []): static
    {
        return new static(
            $taxName,
            $data['value'] ?? 0.0,
            Percentage::fromPercentage($data['percentage'] ?? 0.0)
        );
    }

    public function toArray()
    {
        return [
            'value' => $this->value,
            'percentage' => $this->percentage->get(),
        ];
    }
}
