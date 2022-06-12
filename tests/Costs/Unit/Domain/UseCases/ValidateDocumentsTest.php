<?php

namespace Src\Costs\Domain\UseCases;

use Src\Users\Domain\UseCases\ValidateDocuments;
use Tests\TestCase;

class ValidateDocumentsTest extends TestCase
{
    /**
     * @dataProvider getCPFs
     */
    public function test_should_validate_cpf(string $data, bool $expected): void
    {
        // Act
        $result = ValidateDocuments::validateCPF($data);

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider getCNPJs
     */
    public function test_should_validate_cnpj(string $data, bool $expected): void
    {
        // Act
        $result = ValidateDocuments::validateCNPJ($data);

        // Assert
        $this->assertSame($expected, $result);
    }

    public function getCPFs(): array
    {
        return [
            'when given valid CPF masked' => [
                'data' => '537.925.480-20',
                'expected' => true,
            ],
            'when given valid CPF' => [
                'data' => '83880059012',
                'expected' => true,
            ],
            'when given invalid CPF' => [
                'data' => '11122233345',
                'expected' => false,
            ]
        ];
    }

    public function getCNPJs(): array
    {
        return [
            'when given valid CNPJ masked' => [
                'data' => '90.525.465/0001-59',
                'expected' => true,
            ],
            'when given valid CNPJ' => [
                'data' => '89643399000132',
                'expected' => true,
            ],
            'when given invalid CNPJ' => [
                'data' => '11122233344456',
                'expected' => false,
            ]
        ];
    }
}
