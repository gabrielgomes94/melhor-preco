<?php

namespace Src\Math\Transformers;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Src\Math\Percentage;

class NumberTransformTest extends TestCase
{
    /**
     * @dataProvider getNumbers
     */
    public function test_should_transform_to_float(string|float $number): void
    {
        // Act
        $result = NumberTransformer::toFloat($number);

        // Assert
        $this->assertSame(10.25, $result);
    }

    public function test_should_transform_to_text(): void
    {
        // Act
        $result = NumberTransformer::toText(12.2589);

        // Assert
        $this->assertSame('12,26', $result);
    }

    public function test_should_not_transform_to_money_when_value_is_null(): void
    {
        // Act
        $result = NumberTransformer::toMoney(null);

        // Assert
        $this->assertSame('', $result);
    }

    public function test_should_transform_to_money_when_value_is_float(): void
    {
        // Act
        $result = NumberTransformer::toMoney(250.25);

        // Assert
        $this->assertSame('R$ 250,25', $result);
    }

    public function test_should_transform_to_money_when_value_is_money(): void
    {
        // Act
        $result = NumberTransformer::toMoney(Money::BRL(14990));

        // Assert
        $this->assertSame('R$ 149,90', $result);
    }

    public function test_should_not_transform_to_percentage_when_value_is_null(): void
    {
        // Act
        $result = NumberTransformer::toPercentage(null);

        // Assert
        $this->assertSame('', $result);
    }

    public function test_should_transform_to_percentage(): void
    {
        // Act
        $result = NumberTransformer::toPercentage(Percentage::fromPercentage(15.25));

        // Assert
        $this->assertSame('15,25 %', $result);
    }

    public function getNumbers(): array
    {
        return [
            'when given a float value' => [
                'number' => 10.25,
            ],
            'when given a string value separated by comma' => [
                'number' => '10,25',
            ],
            'when given a string value separated by dot' => [
                'number' => '10.25',
            ],
        ];
    }


}
