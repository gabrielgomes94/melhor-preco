<?php

namespace Src\Sales\Application\Reports\Factories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Tests\Data\Databases\SalesDatabase;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductSalesInMarketplaceReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_report_product_sales_in_marketplaces(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyChair($user);
        SalesDatabase::setup($user);

        /** @var ProductSalesInMarketplaceReport $report */
        $report = app(ProductSalesInMarketplaceReport::class);

        // Act
        $result = $report->report($product->getSku(), $user->getId());

        // Assert
        $this->assertContainsOnlyInstancesOf(MarketplaceSales::class, $result);
        $this->assertCount(2, $result);
        $this->assertSame('olist', $result[0]->marketplace->getSlug());
        $this->assertSame(0, $result[0]->getSalesCount());
        $this->assertSame('shopee', $result[1]->marketplace->getSlug());
        $this->assertSame(1, $result[1]->getSalesCount());
    }

    public function test_should_not_report_when_product_is_not_found(): void
    {
        // Arrange
        $user = UserData::persisted();
        SalesDatabase::setup($user);

        /** @var ProductSalesInMarketplaceReport $report */
        $report = app(ProductSalesInMarketplaceReport::class);

        // Expect
        $this->expectException(ProductNotFoundException::class);

        // Act
        $report->report('invalid-sku', $user->getId());
    }
}
