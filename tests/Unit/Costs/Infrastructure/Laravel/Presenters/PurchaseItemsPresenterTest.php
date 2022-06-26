<?php

namespace Tests\Unit\Costs\Infrastructure\Laravel\Presenters;

use Src\Costs\Infrastructure\Laravel\Presenters\PurchaseItemsPresenter;
use Tests\Data\Models\Costs\PurchaseItemsData;
use Tests\TestCase;

class PurchaseItemsPresenterTest extends TestCase
{
    public function test_should_present_purchase_items(): void
    {
        // Arrange
        $purchaseItem = PurchaseItemsData::make([
            'uuid' => '6e113301-f9ac-44af-85da-d43f3a1652cf',
        ]);

        // Act
        $result = PurchaseItemsPresenter::present($purchaseItem);

        // Assert
        $expected = [
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
        ];

        $this->assertSame($expected, $result);
    }
}
