<?php

namespace Src\Sales\Application\Reports\Data\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Sales\Domain\Models\Collections\SaleItemsCollection;
use Src\Sales\Domain\Services\CalculateItem;
use Src\Sales\Infrastructure\Laravel\Models\Item;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductSalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_product_sales(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyChair($user);
        $marketplace = MarketplaceData::shopee($user);
        $saleItemsCollection = new SaleItemsCollection([
            $item = SaleItemData::make($product, ['unitValue' => 599.9, 'discount' => 20.0]),
            SaleItemData::make($product, ['unitValue' => 599.9, 'discount' => 20.0]),
            SaleItemData::make($product, ['unitValue' => 599.9, 'discount' => 20.0]),
        ]);

//        $calculateItem = app(CalculateItem::class);

        $calculateItem = Mockery::mock(CalculateItem::class);
        $calculatedPrice = Mockery::mock(CalculatedPrice::class);

        // Expect
        $calculateItem->expects()
            ->calculate(Mockery::type(Item::class))
            ->times(9)
            ->andReturn($calculatedPrice);

        $calculatedPrice->expects()
            ->getProfit()
            ->times(9)
            ->andReturn(75.0);

        // Act
        $result = new ProductSales(
            $product,
            $saleItemsCollection,
            $calculateItem
        );

        // Assert
        $this->assertSame(579.9, $result->getAveragePrice());
        $this->assertSame(3, $result->count());
        $this->assertSame(75.0, $result->getAverageProfit());
        $this->assertEquals(12.93, $result->getAverageMargin()->get());
        $this->assertSame(1739.7, $result->getTotalRevenue());
        $this->assertSame(225.0, $result->getTotalProfit());
        $this->assertInstanceOf(Product::class, $result->product);
        $this->assertInstanceOf(Collection::class, $result->saleItemsCollection);
        $this->assertInstanceOf(SaleItemsCollection::class, $result->getSaleItems());
        $this->assertInstanceOf(SaleItemsCollection::class, $result->getLastSales());
    }
}
