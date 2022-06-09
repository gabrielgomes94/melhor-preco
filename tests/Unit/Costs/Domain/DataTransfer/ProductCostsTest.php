<?php

namespace Src\Costs\Domain\DataTransfer;

use PHPUnit\Framework\TestCase;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;

class ProductCostsTest extends TestCase
{
    public function test_should_make_product_costs()
    {
        // Arrange
        $product = ProductData::make();
        $purchaseItemCosts = [
            PurchaseItemsData::make(),
            PurchaseItemsData::make(),
        ];

        // Act
        $result = new ProductCosts($product, $purchaseItemCosts);

        // Assert
        $this->assertEquals($product, $result->product);
        $this->assertContainsOnlyInstancesOf($purchaseItemCosts, $result->purchaseItemCosts);
    }
}
