<?php

namespace Src\Sales\Domain\Models\Data\Shipment;

use Src\Sales\Domain\Models\Data\Shipment\Shipment;
use Src\Sales\Domain\Models\Data\Address\NullAddress;

class NullShipment extends Shipment
{
    public function __construct()
    {
        parent::__construct(new NullAddress(), '');
    }

    public function toArray(): array
    {
        return [];
    }
}
