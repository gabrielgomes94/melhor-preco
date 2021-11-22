<?php

namespace Src\Sales\Domain\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Domain\Events\Contracts\ModelSynchronized;
use Src\Sales\Domain\Models\Item;

class ItemSynchronized implements ModelSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    public function getModel(): Model
    {
        return Item::find($this->itemId);
    }
}
