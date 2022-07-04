<?php

namespace Tests\Unit\Marketplaces\Infrastructure\Domain\DataTransfer;

use Src\Marketplaces\Domain\DataTransfer\MarketplaceSettings;
use Tests\TestCase;

class MarketplaceSettingsTest extends TestCase
{
    public function test_should_instantiate_marketplace_settings(): void
    {
        // Act
        $result = new MarketplaceSettings(
            '123456',
            'Magalu',
            true,
            'uniqueCommission',
            '1'
        );

        // Assert
        $this->assertSame('123456', $result->erpId);
        $this->assertSame('Magalu', $result->name);
        $this->assertTrue($result->isActive);
        $this->assertSame('uniqueCommission', $result->commissionType);
        $this->assertSame('1', $result->userId);
    }
}
