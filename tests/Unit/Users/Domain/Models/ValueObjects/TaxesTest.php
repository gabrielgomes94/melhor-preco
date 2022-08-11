<?php

namespace Src\Users\Domain\Models\ValueObjects;

use PHPUnit\Framework\TestCase;
use Src\Math\Percentage;

class TaxesTest extends TestCase
{
    public function test_should_instantiate(): void
    {
        // Act
        $instance = new Taxes(
            Percentage::fromPercentage(5.345),
            Percentage::fromPercentage(17.5)
        );

        // Assert
        $this->assertEquals(5.345, $instance->simplesNacional->get());
        $this->assertEquals(17.5, $instance->icmsInnerState->get());
    }
}
