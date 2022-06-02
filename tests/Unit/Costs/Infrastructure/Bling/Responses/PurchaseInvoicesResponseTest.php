<?php

namespace Src\Costs\Infrastructure\Bling\Responses;

use Src\Costs\Infrastructure\Laravel\Models\PurchaseInvoice;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\TestCase;

class PurchaseInvoicesResponseTest extends TestCase
{
    public function test_should_make_purchase_invoices_response(): void
    {
        // Act
        $data = [
            PurchaseInvoiceData::make(),
            PurchaseInvoiceData::make(),
            PurchaseInvoiceData::make(),
        ];
        $response = new PurchaseInvoicesResponse($data);

        // Assert
        $this->assertContainsOnlyInstancesOf(PurchaseInvoice::class, $response->data());
        $this->assertSame(3, count($response->data()));
    }

    public function test_should_make_purchase_invoices_response_when_data_is_empty(): void
    {
        // Act
        $response = new PurchaseInvoicesResponse([]);

        // Assert
        $this->assertContainsOnlyInstancesOf(PurchaseInvoice::class, $response->data());
        $this->assertSame(0, count($response->data()));
    }
}
