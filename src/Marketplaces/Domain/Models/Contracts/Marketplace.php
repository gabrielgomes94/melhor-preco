<?php

namespace Src\Marketplaces\Domain\Models\Contracts;

interface Marketplace
{
    public function getCommissionType(): string;

    public function getCommissionValues(): array;

    public function getErpId(): string;

    public function getName(): string;

    public function getSlug(): string;

    public function getUuid(): string;
}
