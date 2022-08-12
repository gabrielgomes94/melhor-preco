<?php

namespace Src\Marketplaces\Domain\Models\Freight;

use PHPUnit\Framework\TestCase;

class FreightTableTest extends TestCase
{
    public function test_should_make_freight_table_instance(): void
    {
        // Act
        $result = new FreightTable([
            new FreightTableComponent(10.0, 0.0, 1.0),
            new FreightTableComponent(20.0, 1.001, 2.0),
            new FreightTableComponent(30.0, 2.001),
        ]);

        // Assert
        $this->assertContainsOnlyInstancesOf(FreightTableComponent::class, $result->get());
    }
}
