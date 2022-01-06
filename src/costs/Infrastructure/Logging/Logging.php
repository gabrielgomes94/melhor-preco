<?php

namespace Src\Costs\Infrastructure\Logging;

use Illuminate\Support\Facades\Log;
use Src\Costs\Domain\Models\PurchaseInvoice;
use Src\Costs\Domain\Models\PurchaseItems;
use Throwable;

class Logging
{
    public static function logSuccessfulItemSync(PurchaseItems $item, PurchaseInvoice $invoice): void
    {
        Log::info('[CUSTOS] Sucesso na sincronização de items: ', [
            'invoice' => $invoice->toArray(),
            'item' => $item,
        ]);
    }

    public static function logSuccessfulItemToProductLink(PurchaseItems $item, string $productSku): void
    {
        Log::info('[CUSTOS] Produto vinculado à nota fiscal', [
            'sku' => $productSku,
            'item' => $item->toArray(),
        ]);
    }

    public static function logFailedItemSync(PurchaseItems $item, PurchaseInvoice $invoice, Throwable $exception): void
    {
        Log::error('[CUSTOS] Erro na sincronização de items: ', [
            'invoice' => $invoice->toArray(),
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'item' => $item->toArray(),
        ]);
    }

    public static function logFailedItemToProductLink(PurchaseItems $item, string $productSku): void
    {
        Log::info('[CUSTOS] Produto não foi vinculado à nota fiscal', [
            'sku' => $productSku,
            'item' => $item->toArray(),
            'errors' => $item->errors(),
        ]);
    }
}
