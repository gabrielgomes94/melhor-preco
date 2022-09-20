<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Marketplaces\MarketplaceData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Sales\SaleItemData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class ShipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_sale_shipment(): void
    {
        // Arrange
        $user = UserData::make();
        $productBabyPacifier = ProductData::babyPacifier($user);
        $marketplace = MarketplaceData::magalu($user);
        $saleOrder = SaleOrderData::persisted(
            $user,
            [],
            [
                SaleItemData::make($productBabyPacifier),
            ],
            $marketplace
        );

        // Act
        $saleShipment = $saleOrder->getShipment();

        // Assert
        $this->assertInstanceOf(Shipment::class, $saleShipment);
        $this->assertInstanceOf(SaleOrder::class, $saleOrder);
        $this->assertSame('João da Silva', $saleShipment->name);
        $this->assertSame(100, $saleShipment->sale_order_id);
        $this->assertSame('Rua Grapecica', $saleShipment->street);
        $this->assertSame('115', $saleShipment->number);
        $this->assertSame('2 andar', $saleShipment->complement);
        $this->assertSame('Brooklyn', $saleShipment->district);
        $this->assertSame('São Paulo', $saleShipment->city);
        $this->assertSame('SP', $saleShipment->state);
        $this->assertSame('1238048', $saleShipment->zipcode);
    }
}
