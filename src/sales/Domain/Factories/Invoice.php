<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Data\Invoice\Invoice as InvoiceData;
use Src\Sales\Domain\Models\Invoice as InvoiceModel;

class Invoice
{
    public static function make(InvoiceData $invoice)
    {
        return new InvoiceModel([
            'series' => $invoice->series(),
            'number' => $invoice->number(),
            'issued_at' => $invoice->issuedAt(),
            'status' => $invoice->status(),
            'value' => $invoice->value(),
            'access_key' => $invoice->accessKey(),
        ]);
    }
}
