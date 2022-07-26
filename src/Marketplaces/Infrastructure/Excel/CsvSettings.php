<?php

namespace Src\Marketplaces\Infrastructure\Excel;

trait CsvSettings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }
}
