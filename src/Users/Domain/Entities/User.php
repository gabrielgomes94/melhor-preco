<?php

namespace Src\Users\Domain\Entities;

use Src\Users\Domain\DataTransfer\Erp;

interface User
{
    public function getId(): string;

    public function getName(): string;

    public function getEmail(): string;

    public function getErpToken(): ?string;

    public function getFiscalId(): string;

    public function getPassword(): string;

    public function getPhone(): string;

    public function setErp(Erp $erp): void;

    public function setPassword(string $hashedPassword): void;

    public function setProfile(string $name, string $phone, string $fiscalId): void;

    public function setTaxRate(float $taxRate = 0.0): void;
}
