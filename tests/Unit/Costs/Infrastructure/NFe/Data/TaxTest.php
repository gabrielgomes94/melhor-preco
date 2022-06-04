<?php

namespace Src\Costs\Infrastructure\NFe\Data;

use Src\Math\Percentage;
use Tests\TestCase;

class TaxTest extends TestCase
{
    public function test_should_make_tax(): void
    {
        // Arrange
        $expected = [
            'value' => 5.0,
            'percentage' => 10.0,
        ];

        // Act
        $result = new Tax(
            'IPI',
            5.0,
            Percentage::fromPercentage(10.0)
        );

        // Assert
        $this->assertSame('IPI', $result->name);
        $this->assertSame(5.0, $result->value);
        $this->assertSame(10.0, $result->percentage->get());
        $this->assertSame($expected, $result->toArray());
    }
}
