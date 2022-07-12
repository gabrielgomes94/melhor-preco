<?php

namespace Src\Sales\Infrastructure\Logging\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogException implements ShouldQueue
{
    public function handle(Throwable $throwable, string $level = 'error')
    {
        Log::log($level, $throwable->getMessage(), [
            'channel' => 'Sales'
        ]);
    }
}
