<?php

namespace Barrigudinha\SaleOrder\ValueObjects\Payment;

class NullPayment extends Payment
{
    public function __construct()
    {
        parent::__construct([]);
    }

    public function toArray(): array
    {
        return [];
    }
}
