<?php

namespace Src\Marketplaces\Infrastructure\Excel\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use PHPUnit\Framework\TestCase;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Tests\Data\Models\Marketplaces\FreightData;

class FreightTableExportTest extends TestCase
{
    public function test_should_make_freight_table_export_object(): void
    {
        // Arrange
        $freightTable = new FreightTable([
            new FreightTableComponent(22.14, 0, 0.5),
            new FreightTableComponent(23.94, 0.501, 1),
            new FreightTableComponent(25.74, 1.001, 2)
        ]);
        $export = new FreightTableExport($freightTable);
        $expected = [
            [
                'De (kg)',
                'Até (kg)',
                'Valor (R$)',
            ],
            [
                0.0,
                0.5,
                22.14,
            ],
            [
                0.501,
                1.0,
                23.94
            ],
            [
                1.001,
                2.0,
                25.74,
            ]
        ];

        // Act
        $result = $export->array();

        // Assert
        $this->assertInstanceOf(FromArray::class, $export);
        $this->assertSame($expected, $result);
    }
}
