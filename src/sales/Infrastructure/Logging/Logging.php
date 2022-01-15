<?php

namespace Src\Sales\Infrastructure\Logging;

use Illuminate\Support\Facades\Log;
use Money\Money;
use Src\Calculator\Domain\Transformer\MoneyTransformer;

class Logging
{
    public static function itemWasSynchronized(array $data)
    {

    }

    public static function priceCalculated(Money $profit)
    {
        Log::info('Preço calculado: ', [
            MoneyTransformer::toFloat($profit ?? Money::BRL(0)),
        ]);
    }

    public static function productNotFound($sku): void
    {
        Log::info('Produto não encontrado.', [
//            'saleOrder' => $saleOrder,
            'sku' => $sku,
        ]);
    }

    public static function storeNotFound($saleOrder): void
    {
        Log::info('Loja nao encontrada', [
            $saleOrder
        ]);
    }
}
