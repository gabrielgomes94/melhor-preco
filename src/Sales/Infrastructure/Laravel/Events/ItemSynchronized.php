<?php

namespace Src\Sales\Infrastructure\Laravel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Infrastructure\Laravel\Events\Contracts\ModelSynchronized;
use Src\Sales\Infrastructure\Laravel\Models\Item;

class ItemSynchronized implements ModelSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    public function getModel(): ?Model
    {
        return Item::find($this->itemId);
    }
}
