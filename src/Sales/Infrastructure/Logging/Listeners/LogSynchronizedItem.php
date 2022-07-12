<?php

namespace Src\Sales\Infrastructure\Logging\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Src\Sales\Infrastructure\Laravel\Events\Contracts\ModelSynchronized;

class LogSynchronizedItem implements ShouldQueue
{
    public function handle(ModelSynchronized $event): void
    {
        $model = $event->getModel();

//        Log::info('Item was synchronized.', $model->toArray());
    }
}
