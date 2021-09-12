<?php

namespace Barrigudinha\SaleOrder\ValueObjects\Shipment;

use Barrigudinha\SaleOrder\ValueObjects\Address\NullAddress;

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
