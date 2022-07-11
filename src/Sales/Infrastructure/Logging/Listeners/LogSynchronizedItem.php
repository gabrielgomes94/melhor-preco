<?php

namespace Src\Sales\Infrastructure\Logging\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Src\Sales\Domain\Events\Contracts\ModelSynchronized;

class LogSynchronizedItem implements ShouldQueue
{
    public function handle(ModelSynchronized $event): void
    {
        $model = $event->getModel();

//        Log::info('Item was synchronized.', $model->toArray());
    }
}
