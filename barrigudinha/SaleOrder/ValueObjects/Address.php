<?php

namespace Barrigudinha\SaleOrder\ValueObjects;

class Address
{
    private string $street;
    private string $number;
    private ?string $complement;
    private string $city;
    private string $state;
    private string $district;
    private string $zipcode;
}
