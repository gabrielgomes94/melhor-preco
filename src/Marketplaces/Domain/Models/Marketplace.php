<?php

namespace Src\Marketplaces\Domain\Models;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Commission;
use Src\Math\Percentage;

interface Marketplace
{
    public function getErpId(): string;

    public function getName(): string;

    public function getPrices(): iterable;

    public function getSlug(): string;

    public function getUuid(): string;

    public function getUserId(): string;

    public function isActive(): bool;

    public function getCommission(): Commission;
}
