<?php

namespace Src\Sales\Domain\Models\Data\Shipment;

use Src\Sales\Domain\Models\Data\Address\Address;

class Shipment
{
    private Address $deliveryAddress;
    private string $name;

    public function __construct(Address $deliveryAddress, string $name)
    {
        $this->deliveryAddress = $deliveryAddress;
        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            'address' => $this->deliveryAddress->toArray(),
            'name' => $this->name,
        ];
    }
}
