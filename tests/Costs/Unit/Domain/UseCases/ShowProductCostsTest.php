<?php

namespace Tests\Costs\Unit\Domain\UseCases;

use Mockery;
use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\TestCase;

class ShowProductCostsTest extends TestCase
{
    public function test_should_show_product_costs(): void
    {
        // Arrange
        $purchaseItem = PurchaseItemsData::make();
        $product = $this->getProduct($purchaseItem);
        $repository = $this->getRepository($product);
        $showProductCosts = new ShowProductCosts($repository);

        $expected = new ProductCosts($product, [$purchaseItem]);

        // Act
        $result = $showProductCosts->show('1234');

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function test_should_handle_when_product_doest_not_exists(): void
    {
        // Arrange
        $purchaseItem = PurchaseItemsData::make();
        $product = $this->getProduct($purchaseItem);
        $repository = $this->getRepository($product);
        $showProductCosts = new ShowProductCosts($repository);

        $expected = new ProductCosts($product, [$purchaseItem]);

        // Act
        $result = $showProductCosts->show('1234');

        // Assert
        $this->assertEquals($expected, $result);
    }

    private function getProduct(PurchaseItem $purchaseItem): Product
    {
        $purchaseItem->setRelation('invoice', PurchaseInvoiceData::make());

        $product = ProductData::make();
        $product->setRelation('itemsCosts', collect([$purchaseItem]));

        return $product;
    }

    private function getRepository(Product $product): ProductRepository
    {
        $repository = Mockery::mock(ProductRepository::class);

        $repository->expects()
            ->get('1234')
            ->andReturn($product);

        return $repository;
    }
}
