<?php

namespace Src\Marketplaces\Infrastructure\Excel\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use PHPUnit\Framework\TestCase;

class FreightTableTemplateExportTest extends TestCase
{
    public function test_should_make_freight_table_template_export_object(): void
    {
        // Arrange
        $export = new FreightTableTemplateExport();
        $expected = [
            [
                'De (kg)',
                'Até (kg)',
                'Valor (R$)',
            ]
        ];

        // Act
        $result = $export->array();

        // Assert
        $this->assertInstanceOf(FromArray::class, $export);
        $this->assertSame($expected, $result);
    }
}
