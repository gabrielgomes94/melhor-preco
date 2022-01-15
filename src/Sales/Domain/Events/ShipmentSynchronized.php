<?php

namespace Src\Sales\Domain\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Sales\Domain\Events\Contracts\ModelSynchronized;
use Src\Sales\Domain\Models\Shipment;

class ShipmentSynchronized implements ModelSynchronized
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $shipmentId;

    public function __construct(string $shipmentId)
    {
        $this->shipmentId = $shipmentId;
    }

    public function getModel(): ?Model
    {
        return Shipment::find($this->shipmentId);
    }
}
