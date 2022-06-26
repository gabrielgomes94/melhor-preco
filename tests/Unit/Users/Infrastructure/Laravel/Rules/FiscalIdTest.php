<?php

namespace Tests\Unit\Users\Infrastructure\Laravel\Rules;

use Src\Users\Infrastructure\Laravel\Rules\FiscalId;
use Tests\TestCase;

class FiscalIdTest extends TestCase
{
    /**
     * @dataProvider getScenarios
     */
    public function test_passes_method(string $data, bool $expected): void
    {
        // Arrange
        $rule = new FiscalId();

        // Act
        $result = $rule->passes('fiscal_id', $data);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function test_message_method(): void
    {
        // Arrange
        $rule = new FiscalId();
        $expected = 'O campo deve ser um CPF ou CNPJ válido.';

        // Act
        $result = $rule->message();

        // Assert
        $this->assertSame($expected, $result);
    }

    public function getScenarios(): array
    {
        return [
            'when given a valid CPF' => [
                'data' => '917.371.450-06',
                'expected' => true,
            ],
            'when given a valid CNPJ' => [
                'data' => '82.337.514/0001-00',
                'expected' => true,
            ],
            'when given an invalid format phone' => [
                'data' => '12345678985',
                'expected' => false,
            ],
        ];
    }
}
