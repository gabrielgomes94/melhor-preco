<?php

namespace Src\Products\Infrastructure\Laravel\Models\Product;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Domain\Models\Category;
use Src\Products\Domain\Models\ValueObjects\Composition;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Domain\Models\ValueObjects\Dimensions;
use Src\Products\Domain\Models\ValueObjects\Identifiers;
use Src\Sales\Application\Models\Item;
use Src\Sales\Application\Models\SaleOrder;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\CategoryData;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Prices\PriceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_product(): void
    {
        // Arrange
        $user = UserData::persisted();
        $this->actingAs($user);
        $marketplace = MarketplaceData::shopee($user);
        $category = CategoryData::babyCarriage($user);

        // Act
        $instance = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 889.90, 'profit' => null])
            ],
            $category
        );

        $invoice = PurchaseInvoiceData::makePersisted($user);
        PurchaseItemsData::makePersisted($invoice, [
            'ean' => '7908238800092',
        ], $instance);

        // Assert
        $this->assertSame('Galzerano', $instance->getBrand());
        $this->assertInstanceOf(Category::class, $instance->getCategory());
        $this->assertSame('10', $instance->getCategoryId());
        $this->assertEquals(new Composition([]), $instance->getComposition());

        $expectedCosts = new Costs(449.9, 0.0, 12.0);
        $this->assertEquals($expectedCosts, $instance->getCosts());

        $this->assertInstanceOf(Carbon::class, $instance->getCreationDate());
        $this->assertSame(1.283, $instance->getCubicWeight());

        $expectedDimensions = new Dimensions(11.0, 25.0, 28.0, 0.3);
        $this->assertEquals($expectedDimensions, $instance->getDimensions());

        $this->assertSame('7908238800092', $instance->getEan());
        $this->assertSame('15865921214', $instance->getErpId());

        $expectedIdentifiers = new Identifiers('1234', '15865921214', '7908238800092');
        $this->assertEquals($expectedIdentifiers, $instance->getIdentifiers());

        $this->assertSame([], $instance->getImages());
        $this->assertInstanceOf(PurchaseItem::class, $instance->getLastPurchaseItemsCosts());
        $this->assertInstanceOf(Carbon::class, $instance->getLastUpdate());
        $this->assertSame('Carrinho de Bebê', $instance->getName());
        $this->assertContainsOnlyInstancesOf(Price::class, $instance->getPrices());
        $this->assertInstanceOf(Price::class, $instance->getPrice($marketplace));
        $this->assertContainsOnlyInstancesOf(PurchaseItem::class, $instance->getPurchaseItemsCosts());
        $this->assertSame(10.0, $instance->getQuantity());
        $this->assertContainsOnlyInstancesOf(SaleOrder::class, $instance->getSaleItems());
        $this->assertSame('1234', $instance->getSku());
        $this->assertInstanceOf(User::class, $instance->getUser());
        $this->assertIsString($instance->getUserId());
        $this->assertFalse($instance->hasCompositionProducts());
        $this->assertFalse($instance->hasVariations());
        $this->assertTrue($instance->isActive());
        $this->assertFalse($instance->isVariation());
    }

    public function test_product_relationships(): void
    {
        // Arrange
        $user = UserData::persisted();
        $this->actingAs($user);
        $marketplace = MarketplaceData::shopee($user);
        $category = CategoryData::babyCarriage($user);

        $invoice = PurchaseInvoiceData::makePersisted($user);
        PurchaseItemsData::makePersisted($invoice, [
            'ean' => '7908238800092',
        ]);

        // Act
        $instance = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 889.90, 'profit' => null]),
            ],
            $category
        );

        // Assert
        $this->assertContainsOnlyInstancesOf(Price::class, $instance->prices);
        $this->assertInstanceOf(Category::class, $instance->category);
        $this->assertContainsOnlyInstancesOf(Item::class, $instance->items);
        $this->assertContainsOnlyInstancesOf(PurchaseItem::class, $instance->itemsCosts);
        $this->assertInstanceOf(User::class, $instance->user);
    }

    public function test_should_set_costs_on_product(): void
    {
        // Arrange
        $user = UserData::persisted();
        $this->actingAs($user);
        $marketplace = MarketplaceData::shopee($user);
        $instance = ProductData::babyCarriage(
            $user,
            [
                PriceData::build($marketplace, ['value' => 889.90, 'profit' => null]),
            ],
        );
        $costs = new Costs(499.9, 10.0, 12.0);

        // Act
        $instance->setCosts($costs);

        // Assert
        $this->assertEquals($costs, $instance->getCosts());
    }
}
