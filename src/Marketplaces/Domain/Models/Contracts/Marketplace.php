<?php

namespace Src\Marketplaces\Domain\Models\Contracts;

use Illuminate\Support\Collection;
use Src\Math\Percentage;

interface Marketplace
{
    public function getCommissionByCategory(?string $categoryId = null): ?Percentage;

    public function getCommissionType(): string;

    public function getCommissionValues(): array;

    public function getCommissions(): array;

    public function getErpId(): string;

    public function getName(): string;

    public function getSlug(): string;

    public function getUuid(): string;

    public function hasUniqueCommission(): bool;

    public function hasCommissionByCategory(): bool;

    public function setCommissionByCategory(Collection $commissions);

    public function setCommissionByUniqueValue(float $commission);
}