<?php

namespace Src\Marketplaces\Domain\Repositories;

use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\Percentage;

interface CommissionRepository
{
    public function get(Marketplace $marketplace, ?string $categoryId = null): Percentage;

    public function updateCategoryCommissions(Marketplace $marketplace, CommissionValuesCollection $data): bool;

    public function updateUniqueCommission(Marketplace $marketplace, float $commission): bool;
}
