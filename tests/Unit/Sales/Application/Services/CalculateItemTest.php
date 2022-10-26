<?php

namespace Src\Sales\Application\Services;


use Src\Marketplaces\Domain\Exceptions\MarketplaceNotFoundException;
use Src\Prices\Domain\Models\Calculator\CalculatedPrice;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class CalculateItemTest extends TestCase
{
    public function test_should_calculate_item(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyChair($user);
        $marketplace = MarketplaceData::shopee($user);
        $item = SaleItemData::make($product, [
            'unitValue' => 599.90
        ]);
        SaleOrderData::persisted(
            $user,
            [],
            [
                $item
            ],
            $marketplace
        );

        /** @var CalculateItem $calculateItemService */
        $calculateItemService = app(CalculateItem::class);

        // Act
        $result = $calculateItemService->calculate($item);

        // Assert
        $this->assertInstanceOf(CalculatedPrice::class, $result);
        $this->assertSame(599.9, $result->get());
        $this->assertSame(388.0, $result->getProfit());
    }

    public function test_should_not_calculate_item_when_marketplace_is_not_found(): void
    {
        // Arrange
        $user = UserData::persisted();
        $product = ProductData::babyChair($user);
        $item = SaleItemData::make($product, [
            'unitValue' => 599.90
        ]);
        SaleOrderData::persisted(
            $user,
            [],
            [
                $item
            ],
        );

        /** @var CalculateItem $calculateItemService */
        $calculateItemService = app(CalculateItem::class);

        // Expect
        $this->expectException(MarketplaceNotFoundException::class);

        // Act
        $calculateItemService->calculate($item);
    }
}
