<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\ValueObjects\Invoice\Invoice as InvoiceData;
use Src\Sales\Domain\Models\ValueObjects\Invoice\NullInvoice;
use Src\Sales\Infrastructure\Laravel\Models\Invoice as InvoiceModel;

class Invoice
{
    public static function make(?InvoiceModel $model)
    {
        if (!$model) {
            return new NullInvoice();
        }

        return new InvoiceData(
            series: $model->series,
            number: $model->number,
            issuedAt: $model->issued_at,
            status: $model->status,
            value: $model->value,
            accessKey: $model->access_key,
        );
    }

    public static function makeModel(InvoiceData $invoice)
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
