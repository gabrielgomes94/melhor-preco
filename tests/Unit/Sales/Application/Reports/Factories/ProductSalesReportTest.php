<?php

namespace Src\Sales\Application\Reports\Factories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Sales\Application\Reports\Data\Product\ProductSales;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductSalesReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_report_product_sales(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyChair($user);
        SalesDatabase::setup($user);

        /** @var ProductSalesReport $report */
        $report = app(ProductSalesReport::class);

        // Act
        $result = $report->report($product->getSku(), $user->getId());

        // Assert
        $this->assertInstanceOf(ProductSales::class, $result);
        $this->assertEquals($product->getSku(), $result->product->getSku());
        $this->assertSame(1, $result->count());
        $this->assertSame(599.9, $result->getTotalRevenue());
    }

    public function test_should_not_report_when_product_is_not_found(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var ProductSalesReport $report */
        $report = app(ProductSalesReport::class);

        // Expect
        $this->expectException(ProductNotFoundException::class);

        // Act
        $report->report('invalid-sku', $user->getId());
    }
}
