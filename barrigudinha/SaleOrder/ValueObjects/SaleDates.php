<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

use Carbon\Carbon;

class SaleDates
{
    private Carbon $selledAt;
    private ?Carbon $dispatchedAt;
    private ?Carbon $expectedArrivalAt;

    public function __construct(Carbon $selledAt, ?Carbon $dispatchedAt, ?Carbon $expectedArrivalAt)
    {
        $this->selledAt = $selledAt;
        $this->dispatchedAt = $dispatchedAt;
        $this->expectedArrivalAt = $expectedArrivalAt;
    }

    public function selledAt(): Carbon
    {
        return $this->selledAt;
    }

    public function toArray(): array
    {
        return [
            'selledAt' => (string) $this->selledAt,
            'dispatchedAt' => (string) $this->dispatchedAt,
            'expectedArrivalAt' => (string) $this->expectedArrivalAt,
        ];
    }
}
