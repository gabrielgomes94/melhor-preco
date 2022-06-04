<?php

namespace Src\Costs\Infrastructure\NFe\Services;

use PHPUnit\Framework\TestCase;
use Tests\Data\NFe\ProductData;

class CalculateUnitCostTest extends TestCase
{
    public function test_should_calculate_unit_cost(): void
    {
        // Arrange
        $product = ProductData::make();
        $calculateUnitCost = new CalculateUnitCost();

        // Act
        $result = $calculateUnitCost->calculate($product);

        // Assert
        $this->assertSame(178.41, $result);
    }
}
