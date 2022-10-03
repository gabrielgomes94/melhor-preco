<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_sale_item(): void
    {
        // Arrange
        $user = UserData::persisted();
        $productBabyPacifier = ProductData::babyPacifier($user);
        $marketplace = MarketplaceData::magalu($user);
        $saleOrder = SaleOrderData::persisted(
            $user,
            [],
            [
                SaleItemData::make($productBabyPacifier),
            ],
            $marketplace
        );

        // Act
        $saleItems = $saleOrder->getItems();
        $saleItem = $saleItems[0];

        // Assert
        $this->assertContainsOnlyInstancesOf(Item::class, $saleItems);
        $this->assertInstanceOf(Marketplace::class, $saleItem->getMarketplace());
        $this->assertInstanceOf(Product::class, $saleItem->getProduct());
        $this->assertSame(1.0, $saleItem->getQuantity());
        $this->assertInstanceOf(SaleOrder::class, $saleItem->getSaleOrder());
        $this->assertSame('2021-12-12 15:40:00', (string) $saleItem->getSelledAt());
        $this->assertSame('777', $saleItem->getSku());
        $this->assertSame(100.0, $saleItem->getTotalValue());
        $this->assertSame(100.0, $saleItem->getUnitValue());
        $this->assertSame(0.0, $saleItem->getDiscount());
    }
}
