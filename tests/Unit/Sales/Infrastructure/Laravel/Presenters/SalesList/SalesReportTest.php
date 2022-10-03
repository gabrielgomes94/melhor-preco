<?php

namespace Src\Sales\Infrastructure\Laravel\Presenters\SalesList;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Domain\Sales\ListReportData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SalesReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_sales_report(): void
    {
        // Arrange
        $salesReport = app(SalesReport::class);
        $user = UserData::persisted();
        $report = ListReportData::make($user);

        // Act
        $result = $salesReport->present($report);

        // Assert
        $expected = [
            'saleOrders' => [
                [
                    'saleOrderCode' => '100',
                    'purchaseSaleOrderId' => '10',
                    'storeSaleOrderId' => '12',
                    'selledAt' => '12/12/2021',
                    'store' => 'Shopee',
                    'value' => 'R$ 100,00',
                    'products' => [],
                    'productsInTooltip' => '',
                    'productsValue' => 1.0,
                    'profit' => 'R$ 20,00',
                    'status' => 'Registrada',
                ],
                [

                ],
            ],
            'total' => [],
        ];
        $this->assertSame($expected['saleOrders'], $result['saleOrders']);
        $this->assertSame($expected['total'], $result['total']);
        $this->assertInstanceOf(Paginator::class, $result['paginator']);
    }
}
