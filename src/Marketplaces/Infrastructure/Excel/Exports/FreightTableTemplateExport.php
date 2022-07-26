<?php

namespace Src\Marketplaces\Infrastructure\Excel\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Src\Marketplaces\Infrastructure\Excel\CsvSettings;

class FreightTableTemplateExport implements FromArray, WithCustomCsvSettings
{
    use CsvSettings;

    public function array(): array
    {
        return [
            [
                'De (kg)',
                'Até (kg)',
                'Valor (R$)'
            ],
        ];
    }
}
