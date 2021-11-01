<?php

namespace Src\Sales\Domain\Models\Data\Customer;

use Src\Sales\Domain\Models\Data\Address\Address;

class Customer
{
    private string $name;
    private string $fiscalId;
    private array $phones;
    private Address $address;
    private ?string $documentNumber;
    private ?string $email;
    private ?string $stateRegistration;

    public function __construct(
        string $name,
        string $fiscalId,
        array $phones,
        Address $address,
        ?string $documentNumber = null,
        ?string $email = null,
        ?string $stateRegistration = null
    ) {
        $this->name = $name;
        $this->fiscalId = $fiscalId;
        $this->stateRegistration = $stateRegistration;
        $this->documentNumber = $documentNumber;
        $this->email = $email;
        $this->phones = $phones;
        $this->address = $address;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->documentNumber;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFiscalId(): string
    {
        return $this->fiscalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhones(): array
    {
        return $this->phones;
    }

    public function getStateRegistration(): ?string
    {
        return $this->stateRegistration;
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
