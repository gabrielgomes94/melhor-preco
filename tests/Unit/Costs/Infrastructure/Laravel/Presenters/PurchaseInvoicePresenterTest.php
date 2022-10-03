<?php

namespace Tests\Unit\Costs\Infrastructure\Laravel\Presenters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseInvoicePresenter;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class PurchaseInvoicePresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_purchase_invoice(): void
    {
        // Arrange
        $user = UserData::persisted();

        $product = ProductData::babyCarriage($user);
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($user, [
            'uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110',
        ]);
        PurchaseItemsData::makePersisted(
            $purchaseInvoice,
            ['uuid' => '6e113301-f9ac-44af-85da-d43f3a1652cf'],
            $product
        );

        $presenter = new PurchaseInvoicePresenter(
            new PurchaseItemsPresenter()
        );

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

        $presenter = new PurchaseInvoicePresenter(
            new PurchaseItemsPresenter()
        );

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
            'value' => 'R$ 1.000,00',
            'status' => 'Registrada',
            'freightValue' => 10.0,
            'insuranceValue' => 0.0,
            'items' => [
                [
                    'issuedAt' => '17/02/2021 09:55',
                    'name' => 'Canguru Balbi Vermelho',
                    'purchasePrice' => 'R$ 150,00',
                    'unitCost' => 'R$ 168,00',
                    'quantity' => 5.0,
                    'totalValue' => 'R$ 840,00',
                    'purchaseItemUuid' => '6e113301-f9ac-44af-85da-d43f3a1652cf',
                    'productSku' => '1234',
                    'costs' => [
                        'purchasePrice' => 'R$ 150,00',
                        'taxes' => 'R$ 40,00',
                        'freight' => 'R$ 10,00',
                        'insurance' => 'R$ 0,00',
                        'icms' => '0,00 %'
                    ],
                    'supplier' => [
                        'name' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                        'fiscalId' => '06981862000200',
                    ],
                ],
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
                'value' => 'R$ 1.000,00',
                'status' => 'Registrada',
            ],
            [
                'uuid' => '16f3eb5f-5af4-419e-8f5d-225884a74d5c',
                'series' => '1',
                'seriesNumber' => '1 - 248284',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 1.000,00',
                'status' => 'Registrada',
            ],
            [
                'uuid' => '49f038d0-21ab-49c0-8071-c82f68930534',
                'series' => '1',
                'seriesNumber' => '1 - 248284',
                'issuedAt' => '17/02/2021',
                'contactName' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'value' => 'R$ 1.000,00',
                'status' => 'Registrada',
            ],
        ];
    }
}
