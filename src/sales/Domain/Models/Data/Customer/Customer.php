<?php

namespace Src\Sales\Domain\Models\Data\Customer;

use Src\Sales\Domain\Models\Data\Address\Address;

class Customer
{
    private string $name;
    private string $fiscalId;
    private string $stateRegistration;
    private string $documentNumber;
    private array $phones;
    private Address $address;
    private ?string $email;

    public function __construct(
        string $name,
        string $fiscalId,
        string $stateRegistration,
        string $documentNumber,
        array $phones,
        Address $address,
        ?string $email = null
    ) {
        $this->name = $name;
        $this->fiscalId = $fiscalId;
        $this->stateRegistration = $stateRegistration;
        $this->documentNumber = $documentNumber;
        $this->email = $email;
        $this->phones = $phones;
        $this->address = $address;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'fiscalId' => $this->fiscalId,
            'stateRegistration' => $this->stateRegistration,
            'documentNumber' => $this->documentNumber,
            'email' => $this->email,
            'phones' => $this->phones,
            'address' => $this->address,
        ];
    }
}
