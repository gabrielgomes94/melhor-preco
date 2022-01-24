<?php

namespace Src\Prices\Infrastructure\Laravel\Logging\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Prices\Domain\Events\PriceWasNotSynchronized;

class LogPriceWasNotSynchronized
{
    public function handle(PriceWasNotSynchronized $event)
    {
        $price = $event->getPrice();
        $sku = $price->getProductSku();
        $store = $price->getStore();

        Log::info("Preço do produto $sku não foi sincronizado na loja $store.", $price->toArray());
    }
}
