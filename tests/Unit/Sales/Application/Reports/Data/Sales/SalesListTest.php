<?php

namespace Src\Sales\Application\Reports\Data\Sales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\Paginator;
use Mockery;
use Src\Sales\Application\Reports\Data\Marketplace\MarketplaceSales;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SalesListTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_sales_list()
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);

        $sales = new SaleOrdersCollection([
            SaleOrderData::sale_100($user),
            SaleOrderData::sale_101($user),
            SaleOrderData::sale_102($user),
        ]);

        $marketplaceSales = new MarketplaceSales($marketplace, $sales);

        $paginator = Mockery::mock(Paginator::class);

        // Act
        $result = new SalesList($sales, [$marketplaceSales], $paginator);

        // Assert
        $this->assertSame(3, $result->count());
        $this->assertContainsOnlyInstancesOf(MarketplaceSales::class, $result->getMarketplaceSales());
        $this->assertSame(4, $result->getProductsCount());
        $this->assertInstanceOf(SaleOrdersCollection::class, $result->getSaleOrders());
        $this->assertSame(326.0, $result->getTotalProfit());
        $this->assertSame(2539.5, $result->getTotalValue());
    }
}
