<?php

namespace Src\Marketplaces\Domain\Models\Freight;

use PHPUnit\Framework\TestCase;

class FreightTest extends TestCase
{
    public function test_should_make_freight_instance(): void
    {
        // Act
        $result = new Freight(
            10.0,
            100.0,
            new FreightTable([
                new FreightTableComponent(10, 0.0, 1.0),
                new FreightTableComponent(20, 1.001, 2.0),
                new FreightTableComponent(30, 2.001),
            ]),
        );

        // Assert
        $this->assertSame(20.0, $result->getFromTable(1.24));
    }
}
