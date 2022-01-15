<?php

namespace Src\Sales\Domain\Models\ValueObjects\Shipment;

use Src\Sales\Domain\Models\ValueObjects\Address\Address;

class Shipment
{
    private Address $deliveryAddress;
    private string $name;

    public function __construct(Address $deliveryAddress, string $name)
    {
        $this->deliveryAddress = $deliveryAddress;
        $this->name = $name;
    }

    public function getDeliveryAddress(): Address
    {
        return $this->deliveryAddress;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'address' => $this->deliveryAddress->toArray(),
            'name' => $this->name,
        ];
    }
}
