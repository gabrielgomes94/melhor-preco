<?php

namespace Src\Products\Application\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Products\Domain\Events\Product\ProductSynchronized;
use Src\Products\Domain\Events\Product\ProductWasNotSynchronized;

class LogProductWasNotSynchronized
{
    public function handle(ProductWasNotSynchronized $event)
    {
        $data = $event->getData();

        Log::info("O produto {$data['sku']} não foi sincronizado.", $data);
    }
}
