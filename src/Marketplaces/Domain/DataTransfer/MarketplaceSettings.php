<?php

namespace Src\Marketplaces\Domain\DataTransfer;

class MarketplaceSettings
{
    public function __construct(
        public readonly string $erpId,
        public readonly string $name,
        public readonly bool $isActive,
        public readonly string $commissionType,
        public readonly string $userId
    ) {
    }
}
