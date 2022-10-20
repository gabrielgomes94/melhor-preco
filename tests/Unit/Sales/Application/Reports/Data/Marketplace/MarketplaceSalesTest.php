<?php

namespace Src\Sales\Application\Reports\Data\Marketplace;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Sales\Domain\Models\Collections\SaleOrdersCollection;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class MarketplaceSalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_marketplace_sales(): void
    {
        // Arrange
        $user = UserData::persisted();
        $marketplace = MarketplaceData::shopee($user);
        $sales = new SaleOrdersCollection([
            SaleOrderData::sale_100($user, [], $marketplace),
            SaleOrderData::sale_101($user, [], $marketplace),
            SaleOrderData::sale_102($user, [], $marketplace),
        ]);

        // Act
        $result = new MarketplaceSales($marketplace, $sales);

        // Assert
        $this->assertSame(2539.5, $result->getTotalValue());
        $this->assertSame(3, $result->getSalesCount());
    }
}
