<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

use Illuminate\Support\Carbon;

class Payment
{
    private string $id;
    private float $value;
    private Carbon $expirationDate;
    private string $observation;
    private string $destination;
    private array $paymentMethod;
}
