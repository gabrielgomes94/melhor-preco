<?php

namespace Tests\Costs\Unit\Domain\UseCases;

use Illuminate\Support\Facades\Event;
use Mockery as m;
use Src\Costs\Domain\Exceptions\UpdateCostsException;
use Src\Costs\Domain\UseCases\UpdateCosts;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Events\Product\ProductCostsUpdated;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;
use Tests\Data\Models\Products\ProductData;
use Tests\TestCase;

class UpdateCostsTest extends TestCase
{
    public function test_should_update_costs(): void
    {
        // Arrange
        Event::fake();
        $productRepository = m::mock(ProductRepository::class);
        $updateCosts = new UpdateCosts($productRepository);
        $products = [
            ProductData::make(),
        ];

        // Expects
        $productRepository->expects()
            ->getProductsAndVariations('1234')
            ->andReturn($products);

        $productRepository->expects()
            ->updateCosts(m::type(Product::class), m::type(Costs::class))
            ->andReturnTrue();

        // Act
        $result = $updateCosts->execute('1234', $data = $this->getCostsData());

        // Assert
        $this->assertTrue($result);
        Event::assertDispatched(ProductCostsUpdated::class);
    }

    public function test_should_handle_when_products_are_not_found(): void
    {
        // Arrange
        Event::fake();
        $productRepository = m::mock(ProductRepository::class);
        $updateCosts = new UpdateCosts($productRepository);

        // Expects
        $productRepository->expects()
            ->getProductsAndVariations('1234')
            ->andReturn([]);


        Event::assertNotDispatched(ProductCostsUpdated::class);
        $this->expectException(ProductNotFoundException::class);

        // Act
        $updateCosts->execute('1234', $this->getCostsData());
    }

    public function test_should_handle_when_product_could_not_be_updated(): void
    {
        // Arrange
        Event::fake();
        $productRepository = m::mock(ProductRepository::class);
        $updateCosts = new UpdateCosts($productRepository);
        $products = [
            ProductData::make(),
        ];

        // Expects
        $productRepository->expects()
            ->getProductsAndVariations('1234')
            ->andReturn($products);

        $productRepository->expects()
            ->updateCosts(m::type(Product::class), m::type(Costs::class))
            ->andReturnFalse();

        Event::assertNotDispatched(ProductCostsUpdated::class);
        $this->expectException(UpdateCostsException::class);

        // Act
        $updateCosts->execute('1234', $this->getCostsData());
    }

    private function getCostsData(): array
    {
        return [
            'purchasePrice' => 10.0,
            'taxICMS' => 4.0,
            'additionalCosts' => 0.0,
        ];
    }

}
