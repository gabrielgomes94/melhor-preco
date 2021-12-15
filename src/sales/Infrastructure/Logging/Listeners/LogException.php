<?php

namespace Src\Sales\Infrastructure\Logging\Listeners;

use Illuminate\Support\Facades\Log;
use Throwable;

class LogException
{
    public static function log(Throwable $throwable, string $level = 'error')
    {
        Log::log($level, $throwable->getMessage(), [
            'channel' => 'Sales'
        ]);
    }
}
