<?php

namespace Src\Math;

use PHPUnit\Framework\TestCase;

class PercentageTest extends TestCase
{
    public function test_should_make_from_fraction(): void
    {
        // Act
        $result = Percentage::fromFraction(0.125);

        // Assert
        $this->assertSame(0.125, $result->getFraction());
        $this->assertSame(12.5, $result->get());
    }

    public function test_should_make_from_percentage(): void
    {
        // Act
        $result = Percentage::fromPercentage(38.95);

        // Assert
        $this->assertSame(0.3895, $result->getFraction());
        $this->assertSame(38.95, $result->get());
    }
}
