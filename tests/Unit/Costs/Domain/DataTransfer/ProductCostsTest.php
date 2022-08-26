<?php

namespace Tests\Unit\Costs\Domain\DataTransfer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ProductCostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_make_product_costs()
    {
        // Arrange
        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $purchaseItemCosts = [
            PurchaseItemsData::make(),
            PurchaseItemsData::make(),
        ];

        // Act
        $result = new ProductCosts($product, $purchaseItemCosts);

        // Assert
        $this->assertEquals($product, $result->product);
        $this->assertContainsOnlyInstancesOf(PurchaseItem::class, $result->purchaseItemCosts);
    }
}
