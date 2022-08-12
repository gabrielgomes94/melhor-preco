<?php

namespace Src\Marketplaces\Domain\Models\Freight;

use PHPUnit\Framework\TestCase;

class FreightTableComponentTest extends TestCase
{
    public function test_should_make_freight_table_component_instance(): void
    {
        // Act
        $result = new FreightTableComponent(10.0, 1.001, 2.0);

        // Assert
        $this->assertSame(10.0, $result->value);
        $this->assertSame(1.001, $result->initialCubicWeight);
        $this->assertSame(2.0, $result->endCubicWeight);
    }
}
