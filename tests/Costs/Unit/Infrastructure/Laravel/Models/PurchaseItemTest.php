<?php

namespace Tests\Costs\Unit\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseItem;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\TestCase;

class PurchaseItemTest extends TestCase
{
    public function test_should_instantiate_model(): void
    {
        // Arrange
        $data = PurchaseItemsData::getPayload();
        $purchaseInvoice = PurchaseInvoiceData::make();
        $purchaseInvoice->uuid = 'c0c68005-1ce8-429b-8c1d-1c4b986343a7';

        // Act
        $purchaseItem = new PurchaseItem($data);
        $purchaseItem->uuid = '33ef9826-5500-4681-8d6d-e10757af8169';
        $purchaseItem->invoice()->associate($purchaseInvoice);

        // Assert
        $this->assertInstanceOf(BelongsTo::class, $purchaseItem->invoice());
        $this->assertInstanceOf(BelongsTo::class, $purchaseItem->product());
        $this->assertSame(10.0, $purchaseItem->getFreightCosts());
        $this->assertSame(0.0, $purchaseItem->getICMSPercentage());
        $this->assertSame(0.0, $purchaseItem->getInsuranceCosts());
        $this->assertSame(8.0, $purchaseItem->getIpiValue());
        $this->assertSame('2021-02-17 09:55:41', $purchaseItem->getIssuedAt()->format('Y-m-d H:i:s'));
        $this->assertSame('Canguru Balbi Vermelho', $purchaseItem->getName());
        $this->assertSame('1', $purchaseItem->getProductSku());
        $this->assertSame('33ef9826-5500-4681-8d6d-e10757af8169', $purchaseItem->getPurchaseItemUuid());
        $this->assertSame(5.0, $purchaseItem->getQuantity());
        $this->assertSame(
            'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
            $purchaseItem->getSupplierName()
        );
        $this->assertSame('06981862000200', $purchaseItem->getSupplierFiscalId());
        $this->assertSame(40.0, $purchaseItem->getTotalTaxesCosts());
        $this->assertSame(840.0, $purchaseItem->getTotalValue());
        $this->assertSame(150.0, $purchaseItem->getUnitPrice());
        $this->assertSame(168.0, $purchaseItem->getUnitCost());
        $this->assertSame('33ef9826-5500-4681-8d6d-e10757af8169', $purchaseItem->getUuid());
    }
}
