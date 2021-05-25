<?php

namespace App\Services\Pricing;

use Barrigudinha\Pricing\Data\Pricing;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExportSpreadsheet
{
    public function export($pricing)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setCellValue('A1', 'ID do Parceiro');
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'Cód Item Parceiro');
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'Preço De');
        $spreadsheet->getActiveSheet()->setCellValue('A4', 'Preço Por');
        $spreadsheet->getActiveSheet()->setCellValue('A5', 'Marca');

        new Pricing()

        dd($spreadsheet);
        return $spreadsheet;
    }
}
