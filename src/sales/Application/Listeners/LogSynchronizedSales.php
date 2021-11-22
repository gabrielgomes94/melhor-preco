<?php

namespace Src\Sales\Application\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Src\Sales\Domain\Events\Contracts\ModelSynchronized;

class LogSynchronizedSales implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(ModelSynchronized $event): void
    {
        $model = $event->getModel();

        Log::info('Sale was synchronized.', $model->toArray());
    }
}
