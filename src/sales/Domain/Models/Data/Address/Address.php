<?php

namespace Src\Sales\Domain\Models\Data\Address;

class Address
{
    private string $street;
    private string $number;
    private ?string $complement;
    private string $district;
    private string $city;
    private string $state;
    private string $zipcode;

    public function __construct(
        string $street,
        string $number,
        string $district,
        string $city,
        string $state,
        string $zipcode,
        ?string $complement
    ) {
        $this->street = $street;
        $this->number = $number;
        $this->district = $district;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
        $this->complement = $complement;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function getDistrict(): string
    {
        return $this->district;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function toArray(): array
    {
        return [
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'district' => $this->district,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode,
        ];
    }
}
