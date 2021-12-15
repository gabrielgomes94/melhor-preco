<?php

namespace Src\Products\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Products\Domain\Events\Product\ProductSynchronized;

class LogProductSynchronized
{
    public function handle(ProductSynchronized $event)
    {
        $sku = $event->getProductSku();

        Log::info("O produto {$sku} foi sincronizado com sucesso.");
    }
}
