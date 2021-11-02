<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Data\Shipment\Shipment as ShipmentData;
use Src\Sales\Domain\Models\Shipment as ShipmentModel;

class Shipment
{
    public static function make(ShipmentData $shipment)
    {
        return new ShipmentModel([
            'name' => $shipment->name(),
        ]);
    }
}
