<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Sales\Domain\Models\ValueObjects\SaleDates;
use Src\Sales\Domain\Models\ValueObjects\SaleIdentifiers;
use Src\Sales\Domain\Models\ValueObjects\SaleValue;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class SaleOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_sale_order(): void
    {
        // Arrange
        $user = UserData::persisted();
        $productBabyPacifier = ProductData::babyPacifier($user);
        $marketplace = MarketplaceData::magalu($user);
        $saleOrder = SaleOrderData::persisted(
            $user,
            [
                'uuid' => '9988ee3a-a462-4c58-aaf7-4db8bc88fcf4',
            ],
            [
                SaleItemData::make($productBabyPacifier),
            ],
            $marketplace
        );

        // Act
        $instance = $saleOrder->refresh();

        // Assert
        $identifiers = new SaleIdentifiers(
            '100',
            '9988ee3a-a462-4c58-aaf7-4db8bc88fcf4',
            'bling',
            '123456',
            '12',
        );
        $this->assertEquals($identifiers, $instance->getIdentifiers());

        $this->assertContainsOnlyInstancesOf(Item::class, $instance->getItems());
        $this->assertCount(1, $instance->getItems());

        $saleValue = new SaleValue(0, 30, 1.0, 100);
        $this->assertEquals($saleValue, $instance->getSaleValue());

        $saleDates = new SaleDates(
            Carbon::create(2021, 12, 12, 15, 40),
            Carbon::create(2021, 12, 12, 18, 00),
            Carbon::create(2021, 12, 16, 12, 00),
        );
        $this->assertEquals($saleDates, $instance->getSaleDates());

        $this->assertInstanceOf(Marketplace::class, $instance->getMarketplace());
        $this->assertSame(20.0, $instance->getProfit());
        $this->assertEquals(
            Carbon::create(2021, 12, 12, 15, 40),
            $instance->getSelledAt()
        );
        $this->assertInstanceOf(Shipment::class, $instance->getShipment());
        $this->assertInstanceOf(Carbon::class, $instance->getLastUpdate());
        $this->assertEquals('Registrada', $instance->getStatus());
        $this->assertEquals('9988ee3a-a462-4c58-aaf7-4db8bc88fcf4', $instance->getUuid());
    }
}
