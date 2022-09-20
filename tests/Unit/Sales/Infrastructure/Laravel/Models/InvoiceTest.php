<?php

namespace Src\Sales\Infrastructure\Laravel\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Data\Models\Sales\SaleInvoiceData;
use Tests\Data\Models\Sales\SaleOrderData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_invoice(): void
    {
        // Arrange
        $user = UserData::make();
        $saleOrder = SaleOrderData::persisted($user);

        // Act
        $saleInvoice = $saleOrder->getInvoice();

        // Assert
        $this->assertInstanceOf(Invoice::class, $saleInvoice);
        $this->assertSame(1, $saleInvoice->id);
        $this->assertSame('001', $saleInvoice->series);
        $this->assertSame('123456', $saleInvoice->number);
        $this->assertEquals('2021-12-12 17:00:00', (string) $saleInvoice->issued_at);
        $this->assertSame('100', $saleInvoice->value);
        $this->assertSame('43140401056417000139550010000123461496923524', $saleInvoice->access_key);
        $this->assertSame(100, $saleInvoice->sale_order_id);
        $this->assertInstanceOf(SaleOrder::class, $saleInvoice->saleOrder);
    }
}
