<?php

namespace Src\Users\Domain\Models;

use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Models\ValueObjects\Taxes;

interface User
{
    public function getId(): string;

    public function getName(): string;

    public function getEmail(): string;

    public function getErpToken(): ?string;

    public function getFiscalId(): string;

    public function getIcmsInnerStateTaxRate(): float;

    public function getPassword(): string;

    public function getPhone(): string;

    public function getSimplesNacionalTaxRate(): float;

    public function setErp(Erp $erp): void;

    public function setPassword(string $hashedPassword): void;

    public function setProfile(string $name, string $phone, string $fiscalId): void;

    public function setTaxes(Taxes $taxes): void;
}
