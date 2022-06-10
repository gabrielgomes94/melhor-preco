<?php

namespace Tests\Costs\Unit\Infrastructure\Laravel\Presenters;

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
            'purchasePrice' => 150.0,
            'additionalCosts' => [
                'freightValue' => 10.0,
                'taxesValue' => 40.0,
                'insuranceValue' => 0.0,
            ],
            'unitValue' => 100.0,
            'quantity' => 5.0,
            'totalValue' => 500.0,
            'purchaseItemUuid' => '6e113301-f9ac-44af-85da-d43f3a1652cf',
            'productSku' => '1',
        ];

        $this->assertSame($expected, $result);
    }
}
