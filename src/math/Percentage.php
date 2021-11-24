<?php

namespace Src\Math;

class Percentage
{
    private float $value;

    private function __construct(float $value)
    {
        $this->value = (float) $value / 100;
    }

    public static function fromFraction(float $value): self
    {
        return new self($value * 100);
    }

    public static function fromPercentage(float $value): self
    {
        return new self($value);
    }

    public function get(): float
    {
        return $this->value;
    }

    public function __toString()
    {
        $fullValue = $this->value * 100;
        $fullValue = number_format($fullValue, 2);

        return "{$fullValue} %";
    }
}
