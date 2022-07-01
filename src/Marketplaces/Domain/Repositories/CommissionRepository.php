<?php

namespace Src\Marketplaces\Domain\Repositories;

interface CommissionRepository
{
    public function updateCategoryCommissions(string $marketplaceSlug, array $data): bool;

    public function updateUniqueCommission(string $marketplaceSlug, float $commission): bool;
}
