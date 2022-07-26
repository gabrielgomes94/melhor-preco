<?php

namespace Src\Marketplaces\Infrastructure\Excel\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Src\Marketplaces\Domain\Models\Freight\FreightTable;
use Src\Marketplaces\Domain\Models\Freight\FreightTableComponent;
use Src\Marketplaces\Infrastructure\Excel\CsvSettings;

class FreightTableExport implements FromArray, WithCustomCsvSettings
{
    use CsvSettings;

    public function __construct(
        private ?FreightTable $freightTable
    )
    {
    }

    public function array(): array
    {
        $header = [
            [
                'De (kg)',
                'Até (kg)',
                'Valor (R$)'
            ],
        ];

        if (!$this->freightTable) {
            return $header;
        }

        $table = collect($this->freightTable->get());
        $body = $table->transform(function(FreightTableComponent $row) {
            return [
                $row->initialCubicWeight,
                $row->endCubicWeight,
                $row->value
            ];
        })->toArray();

        return array_merge($header, $body);
    }
}
