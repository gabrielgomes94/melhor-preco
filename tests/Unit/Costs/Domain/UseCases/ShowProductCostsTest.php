<?php

namespace Tests\Unit\Costs\Domain\UseCases;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\Costs\Domain\DataTransfer\ProductCosts;
use Src\Costs\Domain\UseCases\ShowProductCosts;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Users\Infrastructure\Laravel\Models\User;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ShowProductCostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_show_product_costs(): void
    {
        // Arrange
        $user = UserData::make();
        $purchaseItem = PurchaseItemsData::make();
        $product = $this->getProduct($purchaseItem);
        $repository = $this->getRepository($product, $user);
        $showProductCosts = new ShowProductCosts($repository);

        $expected = new ProductCosts($product, [$purchaseItem]);

        // Act
        $result = $showProductCosts->show('1234', $user->getId());

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function test_should_handle_when_product_doest_not_exists(): void
    {
        // Arrange
        $user = UserData::make();
        $purchaseItem = PurchaseItemsData::make();
        $product = $this->getProduct($purchaseItem);
        $repository = $this->getRepository($product, $user);
        $showProductCosts = new ShowProductCosts($repository);

        $expected = new ProductCosts($product, [$purchaseItem]);

        // Act
        $result = $showProductCosts->show('1234', $user->getId());

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

    private function getRepository(Product $product, User $user): ProductRepository
    {
        $repository = Mockery::mock(ProductRepository::class);

        $repository->expects()
            ->get('1234', $user->getId())
            ->andReturn($product);

        return $repository;
    }
}
