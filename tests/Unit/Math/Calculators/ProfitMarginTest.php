<?php

namespace Src\Math\Calculators;

use PHPUnit\Framework\TestCase;
use Src\Math\Calculators\ProfitMargin;
use Src\Math\Percentage;

class ProfitMarginTest extends TestCase
{
    public function test_should_calculate(): void
    {
        // Act
        $result = ProfitMargin::calculate(250, 35);

        // Assert
        $this->assertEquals(
            Percentage::fromPercentage(14),
            $result
        );
    }

    public function test_should_not_calculate_when_value_is_zero(): void
    {
        // Act
        $result = ProfitMargin::calculate(0, 35);

        // Assert
        $this->assertEquals(
            Percentage::fromPercentage(0),
            $result
        );
    }
}
