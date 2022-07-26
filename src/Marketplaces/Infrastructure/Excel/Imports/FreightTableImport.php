<?php

namespace Src\Marketplaces\Infrastructure\Excel\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Src\Marketplaces\Infrastructure\Excel\CsvSettings;

class FreightTableImport implements WithCustomCsvSettings, WithHeadingRow
{
    use Importable;
    use CsvSettings;
}
