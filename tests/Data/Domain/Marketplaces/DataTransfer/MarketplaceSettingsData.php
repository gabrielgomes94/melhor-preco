<?php

namespace Tests\Data\Domain\Marketplaces\DataTransfer;

use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;

// @todo: mover para pasta Data/Domain/Marketplaces/DataTransfer
class MarketplaceSettingsData
{
    public static function make(array $data = []): MarketplaceSettings
    {
        return new MarketplaceSettings(
            erpId: $data['erpId'] ?? '123456',
            name: $data['name'] ?? 'Magalu',
            isActive: $data['isActive'] ?? true,
            commissionType: $data['commissionType'] ?? 'uniqueCommission',
            userId: $data['userId'] ?? 1
        );
    }
}
