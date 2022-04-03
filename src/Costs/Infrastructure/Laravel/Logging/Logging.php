<?php

namespace Src\Costs\Infrastructure\Laravel\Logging;

use Illuminate\Support\Facades\Log;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Throwable;

class Logging
{
    public static function logSuccessfulItemSync(PurchaseItem $item, PurchaseInvoice $invoice): void
    {
        Log::info('[CUSTOS] Sucesso na sincronização de items: ', [
            'invoice' => $invoice->toArray(),
            'item' => $item,
        ]);
    }

    public static function logSuccessfulItemToProductLink(
        PurchaseItem $item,
        string $productSku
    ): void
    {
        Log::info('[CUSTOS] Produto vinculado à nota fiscal', [
            'sku' => $productSku,
            'item' => $item->toArray(),
        ]);
    }

    public static function logFailedItemSync(
        PurchaseItem $item,
        PurchaseInvoice $invoice,
        Throwable $exception
    ): void
    {
        Log::error('[CUSTOS] Erro na sincronização de items: ', [
            'invoice' => $invoice->toArray(),
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'item' => $item->toArray(),
        ]);
    }

    public static function logFailedItemToProductLink(PurchaseItem $item, string $productSku): void
    {
        Log::info('[CUSTOS] Produto não foi vinculado à nota fiscal', [
            'sku' => $productSku,
            'item' => $item->toArray(),
            'errors' => $item->errors(),
        ]);
    }
}
