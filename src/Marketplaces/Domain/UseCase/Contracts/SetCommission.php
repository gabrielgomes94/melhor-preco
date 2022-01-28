<?php

namespace Src\Marketplaces\Domain\UseCase\Contracts;

use Src\Math\Percentage;

interface SetCommission
{
    public function setCommission(string $storeUuid, string $categoryId, Percentage $commission): bool;
}
