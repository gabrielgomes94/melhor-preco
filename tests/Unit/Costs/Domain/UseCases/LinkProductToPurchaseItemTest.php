<?php

namespace Tests\Unit\Costs\Domain\UseCases;

use Mockery;
use Src\Costs\Domain\Repositories\DbRepository;
use Src\Costs\Domain\UseCases\LinkProductToPurchaseItem;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\TestCase;

class LinkProductToPurchaseItemTest extends TestCase
{
    public function test_should_link(): void
    {
        // Arrange
        $repository = Mockery::mock(DbRepository::class);
        $linkProductToPurchaseItem = new LinkProductToPurchaseItem($repository);
        $purchaseItem = PurchaseItemsData::make();

        // Expects
        $repository->expects()
            ->getPurchaseItem('c9818af7-2a02-4f0b-b7b6-50e398849e77')
            ->andReturn($purchaseItem);

        $repository->expects()
            ->linkItemToProduct($purchaseItem, '1234')
            ->andReturnTrue();

        // Act
        $linkProductToPurchaseItem->link('c9818af7-2a02-4f0b-b7b6-50e398849e77', '1234');
    }

    public function test_should_do_nothing_if_purchase_item_does_not_exists(): void
    {
        // Arrange
        $repository = Mockery::mock(DbRepository::class);
        $linkProductToPurchaseItem = new LinkProductToPurchaseItem($repository);

        // Expects
        $repository->expects()
            ->getPurchaseItem('c9818af7-2a02-4f0b-b7b6-50e398849e77')
            ->andReturnNull();

        // Act
        $linkProductToPurchaseItem->link('c9818af7-2a02-4f0b-b7b6-50e398849e77', '1234');
    }


    public function test_should_link_many_products(): void
    {
        // Arrange
        $repository = Mockery::mock(DbRepository::class);
        $linkProductToPurchaseItem = new LinkProductToPurchaseItem($repository);
        $purchaseItem = PurchaseItemsData::make();

        // Expects
        $repository->expects()
            ->getPurchaseItem('c9818af7-2a02-4f0b-b7b6-50e398849e77')
            ->andReturn($purchaseItem);

        $repository->expects()
            ->linkItemToProduct($purchaseItem, '1234')
            ->andReturnTrue();

        $repository->expects()
            ->getPurchaseItem('5e39d9d4-7597-4507-a2b6-ba7d38b43854')
            ->andReturn($purchaseItem);

        $repository->expects()
            ->linkItemToProduct($purchaseItem, '5433')
            ->andReturnTrue();

        $repository->expects()
            ->getPurchaseItem('2ae5c98a-9e88-4f14-8ecc-849f9ce615f0')
            ->andReturn($purchaseItem);

        $repository->expects()
            ->linkItemToProduct($purchaseItem, '4322')
            ->andReturnTrue();

        // Act
        $linkProductToPurchaseItem->linkManyProducts([
            'c9818af7-2a02-4f0b-b7b6-50e398849e77' => '1234',
            '5e39d9d4-7597-4507-a2b6-ba7d38b43854' => '5433',
            '2ae5c98a-9e88-4f14-8ecc-849f9ce615f0' => '4322',
        ]);
    }
}
