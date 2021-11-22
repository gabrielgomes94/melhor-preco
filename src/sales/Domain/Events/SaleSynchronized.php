<?php

namespace Src\Sales\Domain\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Domain\Events\Contracts\ModelSynchronized;
use Src\Sales\Domain\Models\SaleOrder;

class SaleSynchronized implements ModelSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $saleOrderId;

    public function __construct(string $saleOrderId)
    {
        $this->saleOrderId = $saleOrderId;
    }

    public function getModel(): SaleOrder
    {
        return SaleOrder::find($this->saleOrderId);
    }
}
