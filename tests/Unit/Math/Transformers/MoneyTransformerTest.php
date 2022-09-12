<?php

namespace Src\Math\Transformers;

use Money\Money;
use PHPUnit\Framework\TestCase;

class MoneyTransformerTest extends TestCase
{
    public function test_should_transform_to_float(): void
    {
        // Act
        $result = MoneyTransformer::toFloat(Money::BRL(12599));

        // Assert
        $this->assertSame(125.99, $result);
    }

    public function test_should_transform_to_text(): void
    {
        // Act
        $result = MoneyTransformer::toText(Money::BRL(12599));

        // Assert
        $this->assertSame('R$ 125,99', $result);
    }

    public function test_should_transform_to_money(): void
    {
        // Act
        $result = MoneyTransformer::toMoney(125.99);

        // Assert
        $this->assertEquals(Money::BRL(12599), $result);
    }
}
