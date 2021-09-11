<?php

namespace Barrigudinha\SaleOrder\ValueObjects\Invoice;

use Carbon\Carbon;

class Invoice
{
    private string $series;
    private string $number;
    private Carbon $issuedAt;
    private string $status;
    private float $value;
    private string $accessKey;

    public function __construct(
        string $series,
        string $number,
        Carbon $issuedAt,
        string $status,
        float $value,
        string $accessKey
    ) {
        $this->series = $series;
        $this->number = $number;
        $this->issuedAt = $issuedAt;
        $this->status = $status;
        $this->value = $value;
        $this->accessKey = $accessKey;
    }

    public function toArray(): array
    {
        return [
            'series' => $this->series,
            'number' => $this->number,
            'issuedAt' => (string) $this->issuedAt,
            'status' => $this->status,
            'value' => $this->value,
            'accessKey' => $this->accessKey
        ];
    }
}
