<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

use Carbon\Carbon;

class Invoice
{
    private string $series;
    private string $number;
    private Carbon $issuedAt;
    private string $situation;
    private float $value;
}
