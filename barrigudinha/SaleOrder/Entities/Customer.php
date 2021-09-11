<?php

namespace Barrigudinha\SaleOrder\Entities;

use Barrigudinha\SaleOrder\ValueObjects\Address;

class Customer
{
    private string $name;
    private string $fiscalId; // To Do: talvez converter esse campo para um VO
    private string $stateRegistration;
    private string $documentNumber;
    private Address $address;
    private string $email;
    private array $phones;
}
