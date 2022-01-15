<?php

namespace Src\Sales\Domain\Models\ValueObjects\Customer;

use Src\Sales\Domain\Models\ValueObjects\Address\Address;

class Customer
{
    private string $name;
    private string $fiscalId;
    private array $phones;
    private Address $address;
    private ?string $documentNumber;

    public function __construct(
        string $name,
        string $fiscalId,
        array $phones,
        Address $address,
        ?string $documentNumber = null,
    ) {
        $this->name = $name;
        $this->fiscalId = $fiscalId;
        $this->documentNumber = $documentNumber;
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

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'fiscalId' => $this->fiscalId,
            'documentNumber' => $this->documentNumber,
            'phones' => $this->phones,
            'address' => $this->address,
        ];
    }
}
