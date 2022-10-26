<?php

namespace Src\Sales\Application\Reports\Factories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Sales\Application\Reports\Data\Sales\SalesList;
use Src\Sales\Domain\DataTransfer\SalesFilter;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SalesReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_report_sales(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var SalesReport $report */
        $report = app(SalesReport::class);

        $filter = new SalesFilter($user->getId());

        // Act
        $result = $report->report($filter);

        // Assert
        $this->assertInstanceOf(SalesList::class, $result);
        $this->assertSame(5, $result->count());
        $this->assertCount(2, $result->marketplaceSales);
        $this->assertInstanceOf(Paginator::class, $result->paginator);
    }
}
