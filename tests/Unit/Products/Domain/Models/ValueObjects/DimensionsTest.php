<?php

namespace Src\Products\Domain\Models\ValueObjects;

use PHPUnit\Framework\TestCase;

class DimensionsTest extends TestCase
{
    public function test_should_instantiate_dimensions(): void
    {
        // Act
        $instance = new Dimensions(20.0, 12.0, 30.0, 1.2);

        // Assert
        $this->assertSame(20.0, $instance->depth());
        $this->assertSame(12.0, $instance->height());
        $this->assertSame(30.0, $instance->width());
        $this->assertSame(1.2, $instance->weight());
        $this->assertSame(62.0, $instance->sum());
        $this->assertSame(1.2, $instance->cubicWeight());
    }
}
