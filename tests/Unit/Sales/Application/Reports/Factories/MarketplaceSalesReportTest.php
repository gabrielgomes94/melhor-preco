<?php

namespace Src\Sales\Application\Reports\Factories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplaceSalesReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_report_marketplace_sales(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var MarketplaceSalesReport $report */
        $report = app(MarketplaceSalesReport::class);

        // Act
        $result = $report->report($user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(MarketplaceSales::class, $result);
        $this->assertCount(2, $result);
    }
}
