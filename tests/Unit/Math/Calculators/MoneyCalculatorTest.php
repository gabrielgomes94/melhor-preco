<?php

namespace Src\Math\Calculators;

use Money\Money;
use PHPUnit\Framework\TestCase;

class MoneyCalculatorTest extends TestCase
{
    public function test_should_sum(): void
    {
        // Act
        $result = MoneyCalculator::sum(10, 20, Money::BRL(3000));

        // Assert
        $this->assertSame(60.0, $result);
    }

    public function test_should_throw_error_when_summing_values_with_invalid_type(): void
    {
        // Expect
        $this->expectError();

        // Act
        MoneyCalculator::sum(10, 'abc', Money::BRL(30));
    }

    public function test_should_throw_error_when_subtracting_values_with_invalid_type(): void
    {
        // Expect
        $this->expectError();

        // Act
        MoneyCalculator::subtract(10, 'abc', Money::BRL(30));
    }

    public function test_should_subtract(): void
    {
        // Act
        $result = MoneyCalculator::subtract(10, 20, Money::BRL(3000));

        // Assert
        $this->assertSame(-40.0, $result);
    }

    public function test_should_divide(): void
    {
        // Act
        $result = MoneyCalculator::divide(100, 20);

        // Assert
        $this->assertSame(5.0, $result);
    }

    public function test_should_multiply()
    {
        // Act
        $result = MoneyCalculator::multiply(100, 4);

        // Assert
        $this->assertSame(400.0, $result);
    }
}
