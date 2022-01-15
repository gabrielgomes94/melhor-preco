<?php

namespace Src\Prices\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Prices\Domain\Events\PriceSynchronized;

class LogPriceSynchronized
{
    public function handle(PriceSynchronized $event)
    {
        $price = $event->getPrice();
        $sku = $price->getProductSku();
        $store = $price->getStore();

        Log::info("Preço do produto $sku na loja $store foi sincronizado com sucesso.", $price->toArray());
    }
}
