<?php

namespace Src\Prices\Price\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Prices\Price\Domain\Events\PriceWasNotSynchronized;

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
