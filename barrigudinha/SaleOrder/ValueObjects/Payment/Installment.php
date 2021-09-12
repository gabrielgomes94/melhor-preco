<?php

namespace Barrigudinha\SaleOrder\ValueObjects\Payment;

use Carbon\Carbon;

class Installment
{
    private string $id;
    private float $value;
    private Carbon $expiresAt;
    private string $observation;
    private string $destination;

    public function __construct(string $id, float $value, Carbon $expiresAt, string $observation, string $destination)
    {
        $this->id = $id;
        $this->value = $value;
        $this->expiresAt = $expiresAt;
        $this->observation = $observation;
        $this->destination = $destination;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'expiresAt' => (string) $this->expiresAt,
            'observation' => $this->observation,
            'destination' => $this->destination,
        ];
    }
}
