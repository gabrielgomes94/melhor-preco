<?php

namespace Tests\Unit\Costs\Infrastructure\NFe\Data;

use Src\Costs\Infrastructure\NFe\Data\Tax;
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
        $result = Tax::fromArray(
            'IPI',
            [
                'value' => 5.0,
                'percentage' => 10.0,
            ]
        );

        // Assert
        $this->assertSame('IPI', $result->name);
        $this->assertSame(5.0, $result->value);
        $this->assertSame(10.0, $result->percentage->get());
        $this->assertSame($expected, $result->toArray());
    }
}
