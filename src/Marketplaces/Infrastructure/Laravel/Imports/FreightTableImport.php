<?php

namespace Src\Marketplaces\Infrastructure\Laravel\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FreightTableImport implements WithCustomCsvSettings, WithHeadingRow
{
    use Importable;

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }
}
