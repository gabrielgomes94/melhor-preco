<?php

namespace Tests\Unit\Costs\Infrastructure\Laravel\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\TestCase;

class PurchaseInvoiceTest extends TestCase
{
    public function test_should_instantiate_model(): void
    {
        // Arrange
        $data = PurchaseInvoiceData::getPayload();

        // Act
        $purchaseInvoice = new PurchaseInvoice($data);

        // Assert
        $this->assertSame('1234', $purchaseInvoice->getAccessKey());
        $this->assertSame(
            'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
            $purchaseInvoice->getContactName()
        );
        $this->assertSame('06981862000200', $purchaseInvoice->getFiscalId());
        $this->assertSame(
            '2021-02-17 09:55:41',
            $purchaseInvoice->getIssuedAt()->format('Y-m-d H:i:s')
        );
        $this->assertSame('248284', $purchaseInvoice->getNumber());
        $this->assertSame('1', $purchaseInvoice->getSeries());
        $this->assertSame('Registrada', $purchaseInvoice->getSituation());
        $this->assertSame(1000.0, $purchaseInvoice->getValue());
        $this->assertSame(
            'https://bling.com.br/relatorios/nfe.xml.php?s&chaveAcesso=1234',
            $purchaseInvoice->getXmlUrl()
        );
        $this->assertFalse($purchaseInvoice->hasItems());
        $this->assertInstanceOf(HasMany::class, $purchaseInvoice->items());
    }
}
