<?php

namespace Tests\Data\Models\Marketplaces;

use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;

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
