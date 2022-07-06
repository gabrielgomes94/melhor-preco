<?php

namespace Src\Marketplaces\Domain\Models;

use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;

interface Marketplace
{
    public function getCommission(): Commission;

    public function getErpId(): string;

    public function getName(): string;

    public function getPrices(): iterable;

    public function getSlug(): string;

    public function getUuid(): string;

    public function getUserId(): string;

    public function isActive(): bool;

    public function setCommissions(CommissionValuesCollection $commissions): void;

    public function slugsExists(): bool;
}
