<?php

namespace Tests\Costs\Unit\Infrastructure\Laravel\Presenters;

use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseInvoicePresenter;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\TestCase;

class PurchaseInvoicePresenterTest extends TestCase
{
    public function test_should_present_purchase_invoice(): void
    {
        // Arrange
        $purchaseItem = PurchaseItemsData::make([
            'uuid' => '6e113301-f9ac-44af-85da-d43f3a1652cf',
        ]);
        $purchaseInvoice = PurchaseInvoiceData::make([
            'uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110',
        ]);
        $purchaseInvoice->setRelation('items', collect([$purchaseItem]));

        $presenter = new PurchaseInvoicePresenter();

        // Act
        $result = $presenter->present($purchaseInvoice);

        // Assert
        $this->assertSame(
            $this->getExpectedDataWhenPresentingPurchaseInvoice(),
            $result
        );
    }

    public function test_should_present_list_of_purchase_invoices(): void
    {
        // Arrange
        $data = [
            PurchaseInvoiceData::make([
                'uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110',
            ]),
            PurchaseInvoiceData::make([
                'uuid' => '16f3eb5f-5af4-419e-8f5d-225884a74d5c',
            ]),
            PurchaseInvoiceData::make([
                'uuid' => '49f038d0-21ab-49c0-8071-c82f68930534',
            ]),
        ];

        $presenter = new PurchaseInvoicePresenter();

        // Act
        $result = $presenter->presentList($data);

        // Assert
        $this->assertSame(
            $this->getExpectedDataWhenPresentingPurchaseInvoicesList(),
            $result
        );
    }

    private function getExpectedDataWhenPresentingPurchaseInvoice(): array
    {
        return [
            'uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110',
            'series' => '1',
            'seriesNumber' => '1 - 248284',
            'issuedAt' => '17/02/2021',
            'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
            'number' => '248284',
            'situation' => 'Registrada',
            'fiscalId' => '06981862000200',
            'value' => 'R$ 1.000,00',
            'status' => 'Registrada',
            'freightValue' => 0.0,
            'insuranceValue' => 0.0,
            'items' => [
                [
                    'name' => 'Canguru Balbi Vermelho',
                    'purchasePrice' => 'R$ 150,00',
                    'additionalCosts' => [
                        'freightValue' => 'R$ 10,00',
                        'taxesValue' => 'R$ 40,00',
                        'insuranceValue' => 'R$ 0,00',
                    ],
                    'unitValue' => 'R$ 168,00',
                    'quantity' => 5.0,
                    'totalValue' => 'R$ 840,00',
                    'purchaseItemUuid' => '6e113301-f9ac-44af-85da-d43f3a1652cf',
                    'productSku' => '1',
                ]
            ],
        ];
    }

    private function getExpectedDataWhenPresentingPurchaseInvoicesList(): array
    {
        return [
            [
                'uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110',
                'series' => '1',
                'seriesNumber' => '1 - 248284',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 1.000,00',
                'status' => 'Registrada',
            ],
            [
                'uuid' => '16f3eb5f-5af4-419e-8f5d-225884a74d5c',
                'series' => '1',
                'seriesNumber' => '1 - 248284',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 1.000,00',
                'status' => 'Registrada',
            ],
            [
                'uuid' => '49f038d0-21ab-49c0-8071-c82f68930534',
                'series' => '1',
                'seriesNumber' => '1 - 248284',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 1.000,00',
                'status' => 'Registrada',
            ],
        ];
    }
}
