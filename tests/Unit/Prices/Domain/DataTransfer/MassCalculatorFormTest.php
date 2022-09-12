<?php

namespace Src\Prices\Domain\DataTransfer;

use PHPUnit\Framework\TestCase;

class MassCalculatorFormTest extends TestCase
{
    public function test_should_make_an_instance(): void
    {
        // Act
        $instance = new MassCalculatorForm(12.0, MassCalculationTypes::Discount, '1');

        // Assert
        $this->assertSame(12.0, $instance->value);
        $this->assertSame(MassCalculationTypes::Discount, $instance->calculationType);
        $this->assertSame('1', $instance->category);
    }
}
