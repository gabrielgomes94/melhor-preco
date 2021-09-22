<?php

namespace Barrigudinha\Notification\ValueObjects;

use InvalidArgumentException;

class Type
{
    private array $validTypes = ['alert', 'critical', 'report', 'info'];

    private string $value;

    public function __construct(string $value)
    {
        $this->set($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function set(string $value): void
    {
        if (!in_array($value, $this->validTypes, true)) {
            $validTypes = implode(', ', $this->validTypes);

            throw new InvalidArgumentException("Attribute '{$value}' is not valid. Use: {$validTypes}");
        }

        $this->value = $value;
    }
}
