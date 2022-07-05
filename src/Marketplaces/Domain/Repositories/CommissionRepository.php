<?php

namespace Src\Marketplaces\Domain\Repositories;

use Src\Marketplaces\Domain\DataTransfer\Collections\CommissionValues;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Math\Percentage;

interface CommissionRepository
{
    public function get(Marketplace $marketplace, ?string $categoryId = null): Percentage;

    public function updateCategoryCommissions(Marketplace $marketplace, CommissionValues $data): bool;

    public function updateUniqueCommission(Marketplace $marketplace, float $commission): bool;
}
