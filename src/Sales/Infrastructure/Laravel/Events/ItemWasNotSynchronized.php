<?php

namespace Src\Sales\Infrastructure\Laravel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemWasNotSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }
}
