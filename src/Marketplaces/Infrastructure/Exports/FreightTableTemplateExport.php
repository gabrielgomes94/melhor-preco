<?php

namespace Src\Marketplaces\Infrastructure\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class FreightTableTemplateExport implements FromArray, WithCustomCsvSettings
{
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

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }
}
