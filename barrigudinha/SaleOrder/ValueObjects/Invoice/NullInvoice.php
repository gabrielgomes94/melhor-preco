<?php

namespace Barrigudinha\SaleOrder\ValueObjects\Invoice;

use Carbon\Carbon;

class NullInvoice extends Invoice
{
    public function __construct()
    {
        parent::__construct('', '', new Carbon(), '', 0.0, '');
    }

    public function toArray(): array
    {
        return [];
    }
}
