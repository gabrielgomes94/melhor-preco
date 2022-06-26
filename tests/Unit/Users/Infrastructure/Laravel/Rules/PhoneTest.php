<?php

namespace Tests\Unit\Users\Infrastructure\Laravel\Rules;

use Src\Users\Infrastructure\Laravel\Rules\Phone;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    /**
     * @dataProvider getScenarios
     */
    public function test_passes_method(string $data, bool $expected): void
    {
        // Arrange
        $rule = new Phone();

        // Act
        $result = $rule->passes('phone', $data);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_message_method(): void
    {
        // Arrange
        $rule = new Phone();
        $expected = 'O campo deve ser um telefone no formato válido.';

        // Act
        $result = $rule->message();

        // Assert
        $this->assertSame($expected, $result);
    }

    public function getScenarios(): array
    {
        return [
            'when given a valid cell phone' => [
                'data' => '+5535952331994',
                'expected' => true,
            ],
            'when given a valid landline phone' => [
                'data' => '+553532331994',
                'expected' => true,
            ],
            'when given an invalid format phone' => [
                'data' => '(35) 95233-1994',
                'expected' => false,
            ]
        ];
    }
}
