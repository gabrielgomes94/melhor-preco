<?php

namespace Tests\Data\Models\Sales;

use Carbon\Carbon;
use Src\Sales\Infrastructure\Laravel\Models\Invoice;
use Src\Sales\Infrastructure\Laravel\Models\SaleOrder;

class SaleInvoiceData
{
    public static function build(SaleOrder $saleOrder): Invoice
    {
        return new Invoice([
            'series' => '001',
            'number' => '123456',
            'issued_at' => Carbon::create(2021, 12, 12, 17, 00),
            'status' => '1',
            'value' => 100.0,
            'access_key' => '43140401056417000139550010000123461496923524',
            'sale_order_id' => $saleOrder->getIdentifiers()->id(),
        ]);
    }
}
