<?php

namespace Src\Sales\Infrastructure\Logging\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Sales\Domain\Events\Contracts\ModelSynchronized;

class LogNotSynchronizedItem
{
    public function handle(ModelSynchronized $event): void
    {
        $model = $event->getModel();

        Log::info('Sale was not synchronized.', $model->toArray());
    }
}
