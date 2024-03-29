<?php

namespace Src\Marketplaces\Domain\Models;

use Illuminate\Support\Collection;
use Src\Marketplaces\Domain\Models\Freight\Freight;
use Src\Marketplaces\Domain\Models\Commission\Base\Commission;
use Src\Marketplaces\Domain\Models\Commission\Base\CommissionValuesCollection;
use Src\Prices\Infrastructure\Laravel\Models\Price;

interface Marketplace
{
    public function getCommission(): Commission;

    public function getErpId(): string;

    public function getFreight(): Freight;

    public function getName(): string;

    public function getPrice(string $productSku): ?Price;

    public function getPrices(): Collection;

    public function getSlug(): string;

    public function getUuid(): string;

    public function getUserId(): string;

    public function isActive(): bool;

    public function setFreight(Freight $freight): void;

    public function setCommissions(CommissionValuesCollection $commissions): void;

    public function slugsExists(): bool;
}
