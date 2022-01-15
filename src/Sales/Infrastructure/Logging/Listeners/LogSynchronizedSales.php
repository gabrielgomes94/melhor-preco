<?php

namespace Src\Sales\Infrastructure\Logging\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Src\Sales\Domain\Events\SaleSynchronized;

class LogSynchronizedSales implements ShouldQueue
{
    public function handle(SaleSynchronized $event): void
    {
        $model = $event->getModel();

        if (!$model) {
            return;
        }

        Log::info('Sale was synchronized.', $model->toArray());
    }
}
