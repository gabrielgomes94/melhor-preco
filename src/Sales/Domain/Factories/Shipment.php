<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\ValueObjects\Shipment\NullShipment;
use Src\Sales\Domain\Models\ValueObjects\Shipment\Shipment as ShipmentData;
use Src\Sales\Domain\Models\Shipment as ShipmentModel;

class Shipment
{
    public static function make(?ShipmentModel $model)
    {
        if (!$model) {
            return new NullShipment();
        }

        return new ShipmentData(
            deliveryAddress: $model->address->data(),
            name: $model->name
        );
    }

    public static function makeModel(ShipmentData $shipment)
    {
        return new ShipmentModel([
            'name' => $shipment->name(),
        ]);
    }
}
