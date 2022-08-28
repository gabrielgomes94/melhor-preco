<?php

namespace Tests\Unit\Costs\Infrastructure\Laravel\Presenters;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Tests\Data\Models\Costs\PurchaseInvoiceData;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\Data\Models\Products\ProductData;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class PurchaseItemsPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_present_purchase_items(): void
    {
        // Arrange
        $user = UserData::make();
        $purchaseInvoice = PurchaseInvoiceData::makePersisted($user, [
            'uuid' => '9044ab84-a3bf-485e-ba17-6c9ea6f53110',
        ]);
        $product = ProductData::babyCarriage($user);
        $purchaseItem = PurchaseItemsData::makePersisted(
            $purchaseInvoice,
            ['uuid' => '6e113301-f9ac-44af-85da-d43f3a1652cf'],
            $product
        );
        $presenter = new PurchaseItemsPresenter();

        // Act
        $result = $presenter->present($purchaseItem);

        // Assert
        $expected = [
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
                'insurance' => '',
                'icms' => '0,00 %'
            ],
            'supplier' => [
                'name' => 'TUTTI BABY INDUSTRIA E COMERCIO DE ARTIGOS INFANTIS LTDA',
                'fiscalId' => '06981862000200',
            ],
        ];

        $this->assertSame($expected, $result);
    }
}
