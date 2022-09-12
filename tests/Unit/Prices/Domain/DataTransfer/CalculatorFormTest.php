<?php

namespace Src\Prices\Domain\DataTransfer;

use PHPUnit\Framework\TestCase;
use Src\Math\Percentage;

class CalculatorFormTest extends TestCase
{
    public function test_should_make_instance(): void
    {
        // Act
        $instance = new CalculatorForm(
            1000.0,
            35.9,
            Percentage::fromPercentage(10.0),
            Percentage::fromPercentage(8.0),
        );

        // Assert
        $this->assertSame(1000.0, $instance->desiredPrice);
        $this->assertSame(35.9, $instance->freight);
        $this->assertEquals(Percentage::fromPercentage(10), $instance->commission);
        $this->assertEquals(Percentage::fromPercentage(8), $instance->discount);
        $this->assertSame(920.0, $instance->getPrice());
    }
}
