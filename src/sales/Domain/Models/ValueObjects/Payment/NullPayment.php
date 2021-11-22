<?php

namespace Src\Sales\Domain\Models\ValueObjects\Payment;

use Src\Sales\Domain\Models\ValueObjects\Payment\Payment;

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
