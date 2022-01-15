<?php

namespace Src\Sales\Domain\Models\ValueObjects\Shipment;

use Src\Sales\Domain\Models\ValueObjects\Shipment\Shipment;
use Src\Sales\Domain\Models\ValueObjects\Address\NullAddress;

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
