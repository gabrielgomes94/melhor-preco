<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Address as AddressModel;
use Src\Sales\Domain\Models\Data\Address\Address as AddressData;

class Address
{
    public static function make(AddressData $address)
    {
        return new AddressModel([
            'street' => $address->getStreet(),
            'number' => $address->getNumber(),
            'complement' => $address->getComplement(),
            'district' => $address->getDistrict(),
            'city' => $address->getCity(),
            'state' => $address->getState(),
            'zipcode' => $address->getZipcode(),
        ]);
    }
}
