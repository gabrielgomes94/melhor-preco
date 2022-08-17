<?php

namespace Src\Products\Infrastructure\Laravel\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Repositories\ProductRepository;
use Src\Products\Infrastructure\Laravel\Services\SynchronizeProductCosts;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SynchronizeProductCostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_sync_costs_on_users_products(): void
    {
        // Arrange
        $repository = Mockery::mock(ProductRepository::class);
        $service = new SynchronizeProductCosts($repository);

        $user = UserData::make();
        $product = ProductData::babyCarriage($user);
        $invoice = PurchaseInvoiceData::makePersisted($user);
        PurchaseItemsData::makePersisted($invoice, [
            'product_sku' => 1234,
            'ean' => '7908238800092',
        ]);

        $products = collect([$product]);

        // Expects
        $repository->expects()
            ->all($user->getId())
            ->andReturn($products);

        $costs = new Costs(168.0, 0.0, 0);

        $repository->expects()
            ->updateCosts($product, Mockery::type(Costs::class), $user->getId())
            ->andReturnTrue();

        // Act
        $service->sync($user);
    }
}
