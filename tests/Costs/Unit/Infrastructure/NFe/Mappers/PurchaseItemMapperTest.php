<?php

namespace Tests\Costs\Unit\Infrastructure\NFe\Mappers;

use Src\Costs\Infrastructure\NFe\Mappers\PurchaseItemMapper;
use Src\Costs\Infrastructure\NFe\Services\CalculateUnitCost;
use Tests\Data\NFe\ProductData;
use Tests\TestCase;

class PurchaseItemMapperTest extends TestCase
{
    public function test_should_map(): void
    {
        // Arrange
        $calculateUnitCostService = new CalculateUnitCost();
        $mapper = new PurchaseItemMapper($calculateUnitCostService);
        $product = ProductData::make();
        $expected = [
            'name' => 'Mobile Take Along Magical Tales',
            'unit_price' => 170.91,
            'unit_cost' => 178.41,
            'quantity' => 2.0,
            'freight_cost' => 5.0,
            'insurance_cost' => 2.5,
            'discount' => 0.0,
            'ean' => '7290108861822',
            'taxes' => [
                'totalTaxes' => 101.21,
                'ipi' => [
                    'value' => 0.0,
                    'percentage' => 0.0,
                ],
                'icms' => [
                    'value' => 0.0,
                    'percentage' => 0.0,
                ],
                'pis' => [
                    'value' => 0.0,
                    'percentage' => 0.0,
                ],
                'cofins' => [
                    'value' => 0.0,
                    'percentage' => 0.0,
                ],
            ],
        ];

        // Act
        $result = $mapper->map($product);

        // Assert
        $this->assertSame($expected, $result);
    }
}
