<?php

namespace Src\Products\Infrastructure\Laravel\Logging\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Products\Domain\Events\ProductSynchronized;
use Src\Products\Domain\Events\ProductWasNotSynchronized;

class LogProductWasNotSynchronized
{
    public function handle(ProductWasNotSynchronized $event)
    {
        $data = $event->getData();

        Log::info("O produto {$data['sku']} não foi sincronizado.", $data);
    }
}
