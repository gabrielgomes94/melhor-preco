<?php

namespace Src\Sales\Domain\Factories;

use Src\Sales\Domain\Models\Address as AddressModel;
use Src\Sales\Domain\Models\ValueObjects\Address\Address as AddressData;

class Address
{
    public static function make(AddressModel $model)
    {
        return new AddressData(
            street: $model->street,
            number: $model->number,
            district: $model->district,
            city: $model->city,
            state: $model->state,
            zipcode: $model->zipcode,
            complement: $model->complement ?? null
        );
    }

    public static function makeModel(AddressData $address)
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
